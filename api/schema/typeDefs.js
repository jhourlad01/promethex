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


  type User {
    id: ID!
    name: String!
    email: String!
    email_verified_at: String
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
    
    # User queries
    user(id: ID!): User
  }

  type Mutation {
    # Auth mutations
    login(email: String!, password: String!, remember: Boolean): String
    logout: Boolean
  }
`;

module.exports = typeDefs;
