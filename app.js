const express = require('express');
const mongoose = require('mongoose');
const path = require('path');
const multer = require('multer');
const session = require('express-session');
const dotenv = require('dotenv');
const Project = require('./models/Project'); // Your Mongoose model

dotenv.config();
const app = express();

// Middleware
app.use(express.urlencoded({ extended: true }));
app.use(express.static(path.join(__dirname, 'public')));
app.set('view engine', 'ejs');

app.use(session({
  secret: 'my-secret',
  resave: false,
  saveUninitialized: true
}));

// MongoDB Connection
mongoose.connect(process.env.MONGODB_URI, {
  useNewUrlParser: true,
  useUnifiedTopology: true
}).then(() => console.log('MongoDB Connected'))
  .catch(err => console.log(err));

// Multer config
const storage = multer.diskStorage({
  destination: (req, file, cb) => cb(null, 'public/uploads'),
  filename: (req, file, cb) => cb(null, Date.now() + '-' + file.originalname)
});
const upload = multer({ storage });

// Session middleware
function isLoggedIn(req, res, next) {
  if (req.session && req.session.admin) next();
  else res.redirect('/admin/login');
}

// Routes
// Home page route
app.get('/', (req, res) => {
  res.render('index'); // Make sure home.ejs file exists in views folder
});

app.get('/about', (req, res) => {
  res.render('about'); 
});

app.get('/booking', (req, res) => {
  res.render('booking'); 
});
app.get('/team', (req, res) => {
  res.render('team'); 
});
app.get('/service', (req, res) => {
  res.render('service'); 
});
app.get('/gallery', (req, res) => {
  res.render('gallery'); 
});
app.get('/contact', (req, res) => {
  res.render('contact'); 
});
app.get('/login', (req, res) => {
  res.render('login'); 
});
// Login page
app.get('/admin/login', (req, res) => res.render('login'));
app.post('/admin/login', (req, res) => {
  const { username, password } = req.body;
  if (username === process.env.ADMIN_USERNAME && password === process.env.ADMIN_PASSWORD) {
    req.session.admin = true;
    res.redirect('/admin/upload');
  } else {
    res.send('Invalid credentials');
  }
});

// Upload page
app.get('/admin/upload', isLoggedIn, (req, res) => res.render('upload'));

app.post('/admin/upload', isLoggedIn, upload.single('media'), async (req, res) => {
  const { title, description } = req.body;
  const mediaPath = '/uploads/' + req.file.filename;
  const mediaType = req.file.mimetype.startsWith('video') ? 'video' : 'image';

  await Project.create({ title, description, mediaPath, mediaType });
  res.redirect('/admin/dashboard');
});

// Admin dashboard
app.get('/admin/dashboard', isLoggedIn, async (req, res) => {
  const projects = await Project.find().sort({ createdAt: -1 });
  res.render('dashboard', { projects });
});

// Delete route
app.get('/admin/delete/:id', isLoggedIn, async (req, res) => {
  await Project.findByIdAndDelete(req.params.id);
  res.redirect('/admin/dashboard');
});
// Edit page
app.get('/admin/edit/:id', isLoggedIn, async (req, res) => {
  const project = await Project.findById(req.params.id);
  res.render('edit', { project });
});

app.post('/admin/edit/:id', isLoggedIn, upload.single('media'), async (req, res) => {
  const { title, description } = req.body;
  const updateData = { title, description };

  if (req.file) {
    updateData.mediaPath = '/uploads/' + req.file.filename;
    updateData.mediaType = req.file.mimetype.startsWith('video') ? 'video' : 'image';
  }

  await Project.findByIdAndUpdate(req.params.id, updateData);
  res.redirect('/admin/dashboard');
});

// Our Projects public page
app.get('/our-projects', async (req, res) => {
  const projects = await Project.find().sort({ createdAt: -1 });
  res.render('our-projects', { projects });
});

// Start Server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`Server running on port ${PORT}`));
