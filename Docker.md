# Docker Useful Commands

## Container Management

### 1. **Stop and Remove Containers**

```sh
docker compose down
```

**Usage:** Stops and removes all containers defined in `docker-compose.yml`.

### 2. **Stop a Specific Container**

```sh
docker stop <container_name>
```

**Usage:** Stops a running container without removing it.

### 3. **Remove a Specific Container**

```sh
docker rm <container_name>
```

**Usage:** Removes a stopped container.

### 4. **Remove All Stopped Containers**

```sh
docker container prune
```

**Usage:** Deletes all stopped containers to free up space.

---

## Image Management

### 5. **Build an Image**

```sh
docker compose build
```

**Usage:** Builds images for services defined in `docker-compose.yml`.

### 6. **Build Without Cache**

```sh
docker compose build --no-cache
```

**Usage:** Forces a fresh build without using cached layers.

### 7. **List Docker Images**

```sh
docker images
```

**Usage:** Shows all downloaded and built Docker images.

### 8. **Remove a Docker Image**

```sh
docker rmi <image_id>
```

**Usage:** Deletes an unused image.

### 9. **Remove All Unused Images**

```sh
docker image prune -a
```

**Usage:** Removes all unused images to free space.

---

## Running Containers

### 10. **Start Services in Detached Mode**

```sh
docker compose up -d
```

**Usage:** Starts all services in the background.

### 11. **Start Services with Logs**

```sh
docker compose up
```

**Usage:** Starts services and shows real-time logs.

### 12. **Restart a Specific Container**

```sh
docker restart <container_name>
```

**Usage:** Restarts a running container.

### 13. **List Running Containers**

```sh
docker ps
```

**Usage:** Displays all currently running containers.

### 14. **List All Containers (Including Stopped)**

```sh
docker ps -a
```

**Usage:** Shows all containers, even if they are stopped.

---

## Volume Management

### 15. **List All Volumes**

```sh
docker volume ls
```

**Usage:** Displays all Docker volumes.

### 16. **Remove a Specific Volume**

```sh
docker volume rm <volume_name>
```

**Usage:** Deletes a specific volume.

### 17. **Remove Unused Volumes**

```sh
docker volume prune
```

**Usage:** Removes all unused volumes.

---

## Executing Commands in Containers

### 18. **Access a Running Container**

```sh
docker exec -it <container_name> /bin/sh
```

**Usage:** Opens a shell inside the container.

### 19. **Run a Command Inside a Container**

```sh
docker exec -it <container_name> php artisan migrate
```

**Usage:** Runs Laravel migrations inside the container.

### 20. **Check Container Logs**

```sh
docker logs <container_name>
```

**Usage:** Displays logs of a specific container.

---

## Network Management

### 21. **List Networks**

```sh
docker network ls
```

**Usage:** Shows all Docker networks.

### 22. **Remove a Network**

```sh
docker network rm <network_name>
```

**Usage:** Deletes a specific network.

### 23. **Inspect a Network**

```sh
docker network inspect <network_name>
```

**Usage:** Displays detailed network information.

---

## Database & PHPMyAdmin

### 24. **Access MySQL in Docker**

```sh
docker exec -it laravel_db mysql -uroot -p
```

**Usage:** Logs into MySQL inside the container.

### 25. **Access PHPMyAdmin**

Open browser and go to:

```
http://localhost:8081
```

**Usage:** Accesses PHPMyAdmin for database management.

---

## Cleanup Commands

### 26. **Remove All Stopped Containers, Networks, and Images**

```sh
docker system prune -a
```

**Usage:** Cleans up all unused Docker objects.

### 27. **Force Remove Everything (Use with Caution)**

```sh
docker system prune -a --volumes
```

**Usage:** Removes all containers, images, networks, and volumes.

---

### ✅ **Conclusion**

These commands will help you manage your Laravel and Node.js application inside Docker efficiently! 🚀
