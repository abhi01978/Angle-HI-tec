const mongoose = require('mongoose');

const projectSchema = new mongoose.Schema({
  title: { type: String, required: true },
  description: { type: String, required: true },
  mediaPath: { type: String, required: true },
  mediaType: { type: String, enum: ['image'], default: 'image' },
  section: { type: String, enum: ['before', 'after'], required: true }
}, { timestamps: true });

module.exports = mongoose.model('Project', projectSchema);
