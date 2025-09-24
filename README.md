# Promethex E-Commerce Test App

**Author**: Joe Estrella (jhourest@gmail.com)

A modern e-commerce application built with a custom lightweight PHP framework. Features clean architecture, integrated monitoring vi AI, and flexible configuration for rapid development.

## Features

- 🚀 **Lightweight Framework** - Minimal overhead with maximum performance
- 🐕 **DataDog Integration** - Built-in monitoring, metrics, and logging
- ⚙️ **Interactive Setup** - Automated configuration wizard
- 🔧 **Flexible Features** - Enable/disable components as needed
- 🛡️ **Security First** - Built-in XSS protection, validation, and authentication
- 📊 **Comprehensive Logging** - Structured logging with multiple levels
- 🎯 **API Ready** - RESTful routing with middleware support

## Quick Start

### 1. Installation
```bash
git clone <repository-url>
cd promethex
composer install
```

### 2. Start Development Server
```bash
composer serve
# or
php -S localhost:8000
```

Visit `http://localhost:8000`

## DataDog Monitoring

### 1. Register with DataDog
1. Go to [DataDog](https://www.datadoghq.com/) and create a free account
2. Sign up for a free trial or choose your plan
3. Complete the registration process

### 2. Get Your API Keys
1. Log into your DataDog account
2. Go to **Organization Settings** → **API Keys**
3. Copy your **API Key** (starts with letters/numbers)
4. Go to **Organization Settings** → **Application Keys** 
5. Copy your **Application Key** (starts with letters/numbers)

### 3. Configure Environment
1. Copy `env.example` to `.env`:
   ```bash
   cp env.example .env
   ```

2. Edit `.env` and replace the DataDog entries:
   ```bash
   DATADOG_ENABLED=1
   DD_API_KEY=your_api_key_here
   DD_APP_KEY=your_app_key_here
   DD_SITE=us5.datadoghq.com
   DD_ENV=dev
   DD_APM_INSTRUMENTATION_ENABLED=host
   DD_PROFILING_ENABLED=auto
   ```

### DataDog Dashboard
Visit your DataDog dashboard at [app.datadoghq.com](https://app.datadoghq.com) to view metrics and logs.

## Available Commands

```bash
composer install    # Install dependencies
composer serve      # Start development server
composer dev        # Start development server
composer start      # Start development server
composer dev-win    # Start development server (Windows localhost binding)
```

## Framework Documentation

For detailed framework documentation, see: **[Core Framework README](core/README.md)**

