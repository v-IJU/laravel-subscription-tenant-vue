# Docker Compose Commands Based on Environments (dev.yml, prod.yml)

## General Docker Compose Commands

### 1. Stop and Remove Containers

```sh
docker compose -f dev.yml down
```

**Usage:** Stops and removes all containers, networks, and volumes defined in `dev.yml`. Run before restarting the environment.

```sh
docker compose -f prod.yml down
```

**Usage:** Stops and removes all production containers.

---

### 2. Build Containers Without Cache

```sh
docker compose -f dev.yml build --no-cache
```

**Usage:** Rebuilds all images for the development environment without using cache. Run this when you make changes to the `Dockerfile`.

```sh
docker compose -f prod.yml build --no-cache
```

**Usage:** Rebuilds all production images without cache.

---

### 3. Start Services in Detached Mode

```sh
docker compose -f dev.yml up -d
```

**Usage:** Starts all services defined in `dev.yml` in detached mode (runs in the background).

```sh
docker compose -f prod.yml up -d
```

**Usage:** Starts all production services in detached mode.

---

### 4. View Running Containers

```sh
docker ps
```

**Usage:** Lists all running Docker containers.

```sh
docker compose -f dev.yml ps
```

**Usage:** Lists all running containers in the development environment.

```sh
docker compose -f prod.yml ps
```

**Usage:** Lists all running production containers.

---

### 5. View Logs of Running Services

```sh
docker compose -f dev.yml logs -f
```

**Usage:** Shows logs for all services in `dev.yml` with real-time updates.

```sh
docker compose -f prod.yml logs -f
```

**Usage:** Shows real-time logs for production services.

---

### 6. Execute Commands Inside Containers

```sh
docker exec -it <container_name> sh
```

**Usage:** Opens a shell inside a running container.

Example for Laravel PHP container:

```sh
docker exec -it laravel_app sh
```

Example for MySQL container:

```sh
docker exec -it laravel_db mysql -u root -p
```

---

### 7. Prune Unused Containers and Volumes

```sh
docker system prune -a
```

**Usage:** Removes all stopped containers, unused networks, and dangling images to free up space.

```sh
docker volume prune
```

**Usage:** Removes all unused Docker volumes.

---

### 8. Restart Specific Service

```sh
docker compose -f dev.yml restart app
```

**Usage:** Restarts the `app` service in the development environment.

```sh
docker compose -f prod.yml restart webserver
```

**Usage:** Restarts the `webserver` service in production.

---

### 9. Run Laravel Migrations Inside Docker

```sh
docker exec -it laravel_app php artisan migrate --seed
```

**Usage:** Runs Laravel migrations and seeds the database.

---

### 10. Check Container Status

```sh
docker inspect <container_name>
```

**Usage:** Shows detailed information about a running container.

---

## Conclusion

These commands help efficiently manage **Docker containers** in both **development (`dev.yml`) and production (`prod.yml`) environments**. Use them as needed to build, start, stop, and debug services. 🚀
