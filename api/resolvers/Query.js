const jwt = require('jsonwebtoken');
const bcrypt = require('bcryptjs');

const Query = {
  // Product queries
  async product(parent, { id, slug }, { db }) {
    let query = 'SELECT * FROM products WHERE ';
    let params = [];
    
    if (id) {
      query += 'id = ?';
      params.push(id);
    } else if (slug) {
      query += 'slug = ?';
      params.push(slug);
    } else {
      return null;
    }
    
    const [rows] = await db.execute(query, params);
    return rows[0] || null;
  },

  async products(parent, { featured, category_id, limit = 50 }, { db }) {
    let query = 'SELECT * FROM products WHERE status = "active"';
    let params = [];
    
    if (featured !== undefined) {
      query += ' AND featured = ?';
      params.push(featured);
    }
    
    if (category_id) {
      query += ' AND category_id = ?';
      params.push(category_id);
    }
    
    query += ' ORDER BY created_at DESC';
    
    if (limit) {
      query += ' LIMIT ?';
      params.push(limit);
    }
    
    const [rows] = await db.execute(query, params);
    return rows;
  },

  // Category queries
  async category(parent, { id, slug }, { db }) {
    let query = 'SELECT * FROM categories WHERE ';
    let params = [];
    
    if (id) {
      query += 'id = ?';
      params.push(id);
    } else if (slug) {
      query += 'slug = ?';
      params.push(slug);
    } else {
      return null;
    }
    
    const [rows] = await db.execute(query, params);
    return rows[0] || null;
  },

  async categories(parent, args, { db }) {
    const [rows] = await db.execute(
      'SELECT * FROM categories WHERE is_active = true ORDER BY sort_order ASC'
    );
    return rows;
  },

  // User queries
  async user(parent, { id }, { db }) {
    const [rows] = await db.execute('SELECT * FROM users WHERE id = ?', [id]);
    return rows[0] || null;
  }
};

module.exports = Query;
