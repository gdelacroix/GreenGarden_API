# 🌿 API RESTful - GreenGarden

Cette API RESTful permet la gestion de produits, catégories et fournisseurs pour une application de type e-commerce horticole.

## 🧱 Technologies utilisées

- PHP (POO & MVC)
- MySQL
- Docker & Docker Compose
- Swagger (OpenAPI) pour la documentation
- JSON comme format d'échange

---

## 🚀 Lancer le projet avec Docker

### 1. Cloner ce dépôt

```bash
git clone https://github.com/gdelacroix/GreenGarden_API.git
cd greengarden-api
```
---

### 2. 🚀 Démarrer les conteneurs avec Docker Compose

```bash
docker-compose up -d --build
```

---

### 3. 🌐 Accès à l’API

- **API** : [http://localhost:8080](http://localhost:8080)  
- **Swagger** : [http://localhost:8081/swagger](http://localhost:8081/swagger)  
- **phpMyAdmin** : [http://localhost:8083](http://localhost:8083)  
  - Utilisateur : `root`  
  - Mot de passe : *(vide)*

---

## 📘 Documentation Swagger

Swagger permet de tester facilement les routes de l’API sans avoir besoin d’outils externes.

👉 Accès : [http://localhost:8081/swagger](http://localhost:8081/swagger)

---

## 📬 Endpoints de l'API

### 🔧 Produits

| Méthode | Endpoint               | Description                                          |
|--------:|------------------------|------------------------------------------------------|
| GET     | `/api/products`        | Liste tous les produits ou un seul si on fournit l'id|
| GET     | `/api/product-search`  | Récupère un ou des produits via une recherche        |
| GET     | `/api/product-slug`    | Récupère un produit par son slug                     |
| POST    | `/api/products`        | Crée un nouveau produit                              |
| PUT     | `/api/products`        | Met à jour un produit existant                       |
| DELETE  | `/api/products`        | Supprime un produit                                  |

---

### 📂 Catégories

| Méthode | Endpoint                | Description                         |
|--------:|-------------------------|-------------------------------------|
| GET     | `/api/categories`       | Liste toutes les catégories         |
| POST    | `/api/categories`       | Ajoute une nouvelle catégorie       |

---

### 👤 Fournisseurs

| Méthode | Endpoint                | Description                         |
|--------:|-------------------------|-------------------------------------|
| GET     | `/api/fournisseurs`     | Liste tous les fournisseurs         |
| POST    | `/api/fournisseurs`     | Ajoute un nouveau fournisseur       |

---

### 🔐 Authentification

| Méthode | Endpoint     | Description                      |
|---------|--------------|----------------------------------|
| POST    | /login       | Connexion d’un utilisateur       |
| POST    | /register    | Inscription d’un utilisateur     |

## 🧪 Exemple de requête POST `/api/produits`

```json
{
  "nom_produit": "Bêche pour grand",
  "description_produit": "Bêche pour quelqu'un qui serait assez grand",
  "ref_fournisseur": "BZFR1589",
  "prix_produit": 14.80,
  "categorie": "Bêche",
  "fournisseur": "Paul",
  "image_produit": "photo1.jpg",
  "taux_tva": 5.50
}
```

---

## 📂 Structure du projet

```plaintext
├── app/
│   ├── Controllers/
│   ├── Models/
├── public/              # Point d'entrée (index.php)
├── config/              # Connexion DB, constantes...
├── images/
├── routes/              #organisation des différentes routes
├── docker-compose.yml
├── Dockerfile
├── greengarden.sql
└── README.md
```

---

## 🧹 À faire

- [ ] Ajouter une fonctionnalité pour l'upload de fichier image
- [ ] Ajouter une couche d'authentification (JWT)
- [ ] Gérer les erreurs 404/500 de façon plus fine
- [ ] Implémenter des tests unitaires

