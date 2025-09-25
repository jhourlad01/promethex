const Product = {
  async category(parent, args, { db }) {
    if (!parent.category_id) return null;
    
    const [rows] = await db.execute('SELECT * FROM categories WHERE id = ?', [parent.category_id]);
    return rows[0] || null;
  },

  primary_image(parent) {
    let images = parent.images;
    
    // Parse JSON string if it's a string
    if (typeof images === 'string') {
      try {
        images = JSON.parse(images);
      } catch (e) {
        return null;
      }
    }
    
    if (images && Array.isArray(images)) {
      return images[0] || null;
    }
    return null;
  },

  images(parent) {
    let images = parent.images;
    
    // Parse JSON string if it's a string
    if (typeof images === 'string') {
      try {
        images = JSON.parse(images);
      } catch (e) {
        return [];
      }
    }
    
    if (images && Array.isArray(images)) {
      return images;
    }
    return [];
  },

  stock_quantity(parent) {
    // Ensure stock_quantity is always an integer
    if (parent.stock_quantity === null || parent.stock_quantity === undefined) {
      return 0;
    }
    return parseInt(parent.stock_quantity) || 0;
  }
};

module.exports = Product;
