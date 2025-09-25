const { gql } = require('apollo-server-express');

const typeDefs = gql`
  type Product {
    id: ID!
    name: String!
    slug: String!
    description: String
    short_description: String
    price: Float!
    sale_price: Float
    sku: String
    stock_quantity: Int
    manage_stock: Boolean
    featured: Boolean
    status: String
    in_stock: Boolean
    images: [String]
    primary_image: String
    attributes: String
    weight: Float
    length: Float
    width: Float
    height: Float
    meta_title: String
    meta_description: String
    category: Category
    reviews: [Review]
    average_rating: Float
    total_reviews: Int
    created_at: String
    updated_at: String
  }

  type Category {
    id: ID!
    name: String!
    slug: String!
    description: String
    image_url: String
    products: [Product]
    product_count: Int
    created_at: String
    updated_at: String
  }

  type Review {
    id: ID!
    rating: Int!
    title: String
    comment: String
    is_approved: Boolean
    is_featured: Boolean
    is_verified_purchase: Boolean
    helpful_votes: Int
    helpful_count: Int
    product: Product
    user: User
    created_at: String
    updated_at: String
  }

  type User {
    id: ID!
    name: String!
    email: String!
    email_verified_at: String
    reviews: [Review]
    created_at: String
    updated_at: String
  }

  type Query {
    # Product queries
    product(id: ID, slug: String): Product
    products(featured: Boolean, category_id: ID, limit: Int): [Product]
    
    # Category queries
    category(id: ID, slug: String): Category
    categories: [Category]
    
    # Review queries
    reviews(product_id: ID, approved: Boolean, limit: Int): [Review]
    
    # User queries
    user(id: ID!): User
  }

  type Mutation {
    # Review mutations
    createReview(
      product_id: ID!
      user_id: ID!
      rating: Int!
      title: String
      comment: String
      is_verified_purchase: Boolean
    ): Review
    
    updateReview(
      id: ID!
      rating: Int
      title: String
      comment: String
    ): Review
    
    deleteReview(id: ID!): Boolean
    
    markReviewHelpful(id: ID!): Review
    
    # Auth mutations
    login(email: String!, password: String!, remember: Boolean): String
    logout: Boolean
  }
`;

module.exports = typeDefs;
