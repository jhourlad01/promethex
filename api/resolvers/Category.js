const Category = {
  async products(parent, args, { db }) {
    const [rows] = await db.execute(
      'SELECT * FROM products WHERE category_id = ? AND status = "active" ORDER BY created_at DESC',
      [parent.id]
    );
    return rows;
  },

  async product_count(parent, args, { db }) {
    const [rows] = await db.execute(
      'SELECT COUNT(*) as count FROM products WHERE category_id = ? AND status = "active"',
      [parent.id]
    );
    return parseInt(rows[0].count) || 0;
  }
};

module.exports = Category;
