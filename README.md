# B30sc.co.in WordPress Stack

This repository contains the local development stack for B30sc.co.in using Docker and WordPress.

## Prerequisites

- Docker
- Docker Compose

## Setup

1. **Clone the repository** (if you haven't already).

2. **Configure Environment Variables**:
   Copy the example environment file:
   ```bash
   cp .env.example .env
   ```
   The `.env` file contains database credentials and the site URL. You can adjust `WP_PORT` if port 8000 is occupied.

3. **Initialize WordPress Content**:
   Before starting the stack for the first time, populate the `wp-content` directory so you have the default themes and plugins available locally:
   ```bash
   bash init-wp.sh
   ```

4. **Start the Stack**:
   ```bash
   docker compose up -d
   ```

5. **First-Time Setup**:
   - Open [http://localhost:8000](http://localhost:8000) in your browser.
   - Follow the WordPress installation wizard to create your admin account.
   - Once logged in, go to **Settings > Permalinks** and choose your preferred structure (e.g., "Post name") to enable pretty permalinks. The environment is pre-configured to support this (mod_rewrite is enabled).

## Directory Structure

- `docker-compose.yml`: Defines the WordPress and MySQL services.
- `wp-config.php`: Custom WordPress configuration file that reads settings from environment variables and handles HTTPS behind proxies.
- `wp-content/`: Mapped to `/var/www/html/wp-content` in the container. Themes and plugins live here.
- `.env`: Environment variables (not checked in).

## Common Operations

- **Stop the stack**:
  ```bash
  docker compose down
  ```

- **Stop and remove volumes** (reset database):
  ```bash
  docker compose down -v
  ```

- **View logs**:
  ```bash
  docker compose logs -f
  ```
