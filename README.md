#  Mi Primer Servidor en Apache (Debian)

Plantilla de inicio en **PHP + Tailwind CSS** diseñada para el **Taller de Introducción a Linux** de [StellaLabs](https://stellalabs.tech/). Esta página web interactiva recopila y muestra telemetría en tiempo real del entorno (software web, versión de intérprete PHP, dirección IP y carga del sistema) directamente desde tu propia máquina virtual.

---

## 📋 Requisitos Previos

- Sistema operativo **Debian GNU/Linux 13 (Trixie)** (o derivados basados en Debian/Ubuntu).
- Usuario con privilegios de superusuario (`sudo`).
- Conexión a Internet activa en la máquina virtual (Modo NAT o Puente en VMware).

---

## 🛠️ Guía Rápida de Despliegue

Sigue estos pasos en la terminal de tu sistema para dejar el servidor funcionando:

### 1. Actualizar repositorios e instalar paquetes necesarios

Abre tu terminal (<kbd>Ctrl</kbd> + <kbd>Alt</kbd> + <kbd>T</kbd>) e instala el servidor web **Apache2**, el entorno de ejecución de **PHP** y **Git**:

```bash
sudo apt update
sudo apt install -y apache2 php libapache2-mod-php git
```

### 2. Verificar el estado del servicio

Comprueba que Apache se haya iniciado y esté en ejecución:

```bash
systemctl status apache2
```

> 💡 *Nota:* Presiona la tecla <kbd>q</kbd> en tu teclado para salir de la vista de estado de `systemctl`.

---

### 3. Ajustar permisos del directorio web

Por defecto, el directorio `/var/www/html` pertenece al usuario `root:root`, lo que impide clonar o modificar archivos con tu usuario estándar. Ajusta la propiedad y los permisos de escritura ejecutando:

```bash
sudo chown -R $USER:www-data /var/www/html
sudo chmod -R 775 /var/www/html
```

---

### 4. Limpiar el directorio y clonar este repositorio

Dirígete a la raíz del servidor web, elimina la página de bienvenida predeterminada de Apache y clona el proyecto:

```bash
cd /var/www/html
rm -f index.html
git clone https://github.com/alessgii/curso-apache2 .
```

> ⚠️ **Importante:** Observa el punto (`.`) al final del comando `git clone`. Ese punto indica que el contenido se descargará directamente en la carpeta actual y no dentro de un subdirectorio.

---

### 5. Probar tu sitio en el navegador

1. **Desde la misma máquina virtual:**
   Abre el navegador web de Debian y dirígete a:
   ```text
   http://localhost
   ```

2. **Desde tu computadora anfitriona (Windows / Mac):**
   Obtén la dirección IP local de tu máquina virtual con:
   ```bash
   ip a
   ```
   Ubica tu interfaz de red principal (por ejemplo, `ens33` o `eth0`) y localiza el valor junto a `inet` (ej. `192.168.1.85`). Introduce esa dirección en el navegador de tu computadora principal:
   ```text
   http://192.168.X.X
   ```

---

## 📌 Comandos de Diagnóstico y Administración

| Acción | Comando |
|---|---|
| **Reiniciar Apache** (tras cambios de config) | `sudo systemctl restart apache2` |
| **Monitorear accesos en tiempo real** | `sudo tail -f /var/log/apache2/access.log` |
| **Monitorear errores en tiempo real** | `sudo tail -f /var/log/apache2/error.log` |
| **Editar la página web en consola** | `nano /var/www/html/index.php` |

---

## 📚 Enlaces de Apoyo

- 📖 **Guía completa del taller:** [stellalabs.tech/guias/linux](https://stellalabs.tech/guias/linux)
- 🌐 **Plataforma general de StellaLabs:** [stellalabs.tech](https://stellalabs.tech/)
---

<div align="center">
  <sub>Construido con fines educativos por la comunidad de <b>StellaLabs</b> — <i>Por y para estudiantes.</i></sub>
</div>
