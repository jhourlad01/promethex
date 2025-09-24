const Review = {
  async product(parent, args, { db }) {
    if (!parent.product_id) return null;
    
    const [rows] = await db.execute('SELECT * FROM products WHERE id = ?', [parent.product_id]);
    return rows[0] || null;
  },

  async user(parent, args, { db }) {
    if (!parent.user_id) return null;
    
    const [rows] = await db.execute('SELECT id, name, email, email_verified_at, created_at, updated_at FROM users WHERE id = ?', [parent.user_id]);
    return rows[0] || null;
  }
};

module.exports = Review;
