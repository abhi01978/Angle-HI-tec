const express = require('express');
const router = express.Router();
const Project = require('../models/Project');
const multer = require('multer');
const path = require('path');
require('dotenv').config();

// Multer config
const storage = multer.diskStorage({
  destination: (req, file, cb) => cb(null, 'public/uploads'),
  filename: (req, file, cb) => cb(null, Date.now() + '-' + file.originalname)
});
const upload = multer({ storage });

// Session Middleware
function isLoggedIn(req, res, next) {
  if (req.session && req.session.admin) next();
  else res.redirect('/admin/login');
}
// Example route
router.get('/login', (req, res) => {
  res.send("Login page");
});

// Login page
router.get('/login', (req, res) => res.render('login'));
router.post('/login', (req, res) => {
  const { username, password } = req.body;
  if (username === process.env.ADMIN_USERNAME && password === process.env.ADMIN_PASSWORD) {
    req.session.admin = true;
    res.redirect('/admin/upload');
  } else {
    res.send('Invalid credentials');
  }
});

// Upload page
router.get('/upload', isLoggedIn, (req, res) => res.render('upload'));
router.post('/upload', isLoggedIn, upload.single('media'), async (req, res) => {
  const { title, description } = req.body;
  const mediaPath = '/uploads/' + req.file.filename;
  const mediaType = req.file.mimetype.startsWith('video') ? 'video' : 'image';

  await Project.create({ title, description, mediaPath, mediaType });
  res.redirect('/admin/dashboard');
});

// Dashboard page
router.get('/dashboard', isLoggedIn, async (req, res) => {
  const projects = await Project.find().sort({ createdAt: -1 });
  res.render('dashboard', { projects });
});

// Edit/Delete (optional)
router.get('/delete/:id', isLoggedIn, async (req, res) => {
  await Project.findByIdAndDelete(req.params.id);
  res.redirect('/admin/dashboard');
});
