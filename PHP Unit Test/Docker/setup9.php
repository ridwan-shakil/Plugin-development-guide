<?php
//=========================== Docker environment for wp development =============================
// Step 1: Install prerequisites ==============
// Make sure the system has:
//   Docker
//   Docker Compose (v2 recommended)
// Verify:
  docker --version
  docker compose version

// Step 2: Place files in a folder ================
// Create a folder for the project, e.g., docker-wp-project, and put these inside:
    docker-compose.yml    ;// inside docker-compose.yml change containers name 
    Dockerfile.cli

;// Step 3: Build Docker images ===================
// From inside the folder:
docker compose build

;// This builds the cli container with WP CLI + PHPUnit.
// Other containers (wordpress, db, db_test, phpmyadmin) use prebuilt images.

// Step 4: Start all containers ====================
// Run:
docker compose up -d

;// -d → detached mode (runs in background)
// Containers that start:
// db → primary MariaDB
// db_test → test MariaDB
// wordpress → dev WordPress site
// phpmyadmin → optional DB GUI at http://localhost:8081
// cli → WP CLI + PHPUnit shell


// Step 5: Access the CLI container =====================
// Open the CLI container shell to run commands: Inside the container, WP CLI and PHPUnit are ready to use.

docker compose exec cli bash


;// Step 6: Navigate to your plugin =====================
// Inside the CLI container:

cd wp-content/plugins/your-plugin-slug

;// ==========================================================
