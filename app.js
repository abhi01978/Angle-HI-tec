const express = require('express');
const mongoose = require('mongoose');
const path = require('path');
const multer = require('multer');
const session = require('express-session');
const dotenv = require('dotenv');
const Project = require('./models/Project');

dotenv.config();
const app = express();

// ======= MIDDLEWARE =======
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));
app.set('view engine', 'ejs');

app.use(session({
  secret: 'my-secret',
  resave: false,
  saveUninitialized: true
}));

// ✅ Set user globally in res.locals (for conditional navbar etc.)
app.use((req, res, next) => {
  res.locals.user = req.session.user || null;
  next();
});

// ======= MONGODB CONNECTION =======
mongoose.connect(process.env.MONGODB_URI, {
  useNewUrlParser: true,
  useUnifiedTopology: true
}).then(() => console.log('✅ MongoDB Connected'))
  .catch(err => console.log('❌ MongoDB Error:', err));

// ======= MULTER CONFIGURATION =======
const storage = multer.diskStorage({
  destination: (req, file, cb) => cb(null, 'public/uploads/'),
  filename: (req, file, cb) => cb(null, Date.now() + '-' + file.originalname)
});

const fileFilter = (req, file, cb) => {
  const ext = path.extname(file.originalname).toLowerCase();
  const allowedExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.webp'];

  if (allowedExtensions.includes(ext) && file.mimetype.startsWith('image/')) {
    cb(null, true);
  } else {
    cb(null, false); // Not an error, just reject the file
  }
};

const upload = multer({ storage, fileFilter });

// ======= AUTH CHECK =======
function isLoggedIn(req, res, next) {
  if (req.session && req.session.admin) return next();
  return res.redirect('/admin/login');
}

// ======= View Rendering Helper =======
function renderWithUser(view) {
  return (req, res) => res.render(view);
}

// ======= PUBLIC ROUTES =======
app.get('/', renderWithUser('index'));
app.get('/about', renderWithUser('about'));
app.get('/booking', renderWithUser('booking'));
app.get('/team', renderWithUser('team'));
app.get('/service', renderWithUser('service'));
app.get('/gallery', renderWithUser('gallery'));
app.get('/contact', renderWithUser('contact'));
app.get('/login', renderWithUser('login'));

// ======= PUBLIC PROJECTS PAGE =======
app.get('/our-projects', async (req, res) => {
  const beforeProjects = await Project.find({ section: 'before' }).sort({ createdAt: -1 });
  const afterProjects = await Project.find({ section: 'after' }).sort({ createdAt: -1 });

  res.render('our-projects', {
    beforeProjects,
    afterProjects
  });
});

// ======= ADMIN AUTH =======
app.get('/admin/login', renderWithUser('login'));

app.post('/admin/login', (req, res) => {
  const { username, password } = req.body;

  if (
    username === process.env.ADMIN_USERNAME &&
    password === process.env.ADMIN_PASSWORD
  ) {
    req.session.admin = true;
    req.session.user = username;
    return res.redirect('/admin/upload');
  }

  res.send('❌ Invalid credentials');
});

// ======= ADMIN ROUTES =======
app.get('/admin/upload', isLoggedIn, renderWithUser('upload'));

app.post('/admin/upload', isLoggedIn, (req, res) => {
  upload.single('media')(req, res, async function (err) {
    if (!req.file) {
      return res.status(400).send('❌ No image uploaded or unsupported file format.');
    }

    const { title, description, section } = req.body;
    const mediaPath = '/uploads/' + req.file.filename;

    try {
      await Project.create({
        title,
        description,
        section,
        mediaPath,
        mediaType: 'image'
      });
      res.redirect('/admin/dashboard');
    } catch (error) {
      res.status(500).send('❌ Error saving project: ' + error.message);
    }
  });
});

// ======= DASHBOARD =======
app.get('/admin/dashboard', isLoggedIn, async (req, res) => {
  const projects = await Project.find().sort({ createdAt: -1 });
  res.render('dashboard', { projects });
});

// ======= EDIT PROJECT =======
app.get('/admin/edit/:id', isLoggedIn, async (req, res) => {
  const project = await Project.findById(req.params.id);
  if (!project) return res.send('❌ Project not found');

  res.render('edit', {
    project,
    error: null
  });
});

app.post('/admin/edit/:id', isLoggedIn, (req, res) => {
  upload.single('media')(req, res, async function (err) {
    const project = await Project.findById(req.params.id);
    if (!req.file && err) {
      return res.status(400).render('edit', {
        project,
        error: '❌ Invalid image file. Please upload a valid image.'
      });
    }

    const { title, description, section } = req.body;
    const updateData = { title, description, section };

    if (req.file) {
      updateData.mediaPath = '/uploads/' + req.file.filename;
      updateData.mediaType = 'image';
    }

    try {
      await Project.findByIdAndUpdate(req.params.id, updateData);
      res.redirect('/admin/dashboard');
    } catch (error) {
      res.status(500).send('❌ Error updating project.');
    }
  });
});

// ======= DELETE PROJECT =======
app.get('/admin/delete/:id', isLoggedIn, async (req, res) => {
  try {
    await Project.findByIdAndDelete(req.params.id);
    res.redirect('/admin/dashboard');
  } catch (err) {
    res.status(500).send('❌ Error deleting project');
  }
});

// ======= LOGOUT =======
app.get('/logout', (req, res) => {
  req.session.destroy(() => {
    res.redirect('/');
  });
});

// ======= SERVER =======
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`🚀 Server running on port ${PORT}`));
