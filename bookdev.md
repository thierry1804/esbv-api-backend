# Documentation Technique - Eshop By Valsue API

## Architecture du Projet

L'API est construite avec Symfony 6.4 et API Platform, suivant les principes REST et GraphQL. Les composants principaux sont :
- API Platform : Framework API principal (REST + GraphQL)
- Controllers : Gestion des cas spécifiques hors API Platform
- ApiResource : Configuration des ressources API
- Entities : Représentation des données avec attributs API Platform
- DataProvider/DataPersister : Personnalisation des opérations CRUD
- EventListeners & Subscribers : Gestion des événements
- Security : Gestion des authentifications et validations
- JWT : Authentification par token

## Structure des Dossiers

```
esbv-api-backend/
├── bin/
├── config/
│   ├── packages/
│   │   ├── api_platform/
│   │   ├── lexik_jwt_authentication/
│   │   └── security/
│   ├── routes/
│   └── services.yaml
├── migrations/
├── public/
│   └── api/
│       └── swagger-ui/
├── src/
│   ├── ApiResource/
│   ├── Controller/
│   ├── Entity/
│   ├── DataProvider/
│   ├── DataPersister/
│   ├── State/
│   ├── OpenApi/
│   └── Security/
├── templates/
├── tests/
└── var/
    ├── cache/
    └── log/
```

## Authentification et Sécurité

### Configuration JWT
L'authentification utilise les JSON Web Tokens (JWT) via le bundle LexikJWTAuthenticationBundle.

#### Génération des Clés
```bash
php bin/console lexik:jwt:generate-keypair
```

#### Configuration JWT
La configuration se trouve dans `config/packages/lexik_jwt_authentication.yaml` :
```yaml
lexik_jwt_authentication:
    secret_key: '%kernel.project_dir%/config/jwt/private.pem'
    public_key: '%kernel.project_dir%/config/jwt/public.pem'
    token_ttl: 3600
```

### Endpoint d'Authentification

#### Login Check
- URL : `/api/login_check`
- Méthode : POST
- Corps de la requête :
```json
{
    "email": "user@example.com",
    "password": "password123"
}
```
- Réponse :
```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...",
    "user": {
        "email": "user@example.com",
        "roles": ["ROLE_USER"]
    }
}
```

### Sécurité des Routes

Les routes sont sécurisées selon les rôles suivants :

#### Accès Public
- Documentation API (`/api/docs`)
- Login (`/api/login_check`)
- Lecture des produits et catégories
- Création de contacts

#### Accès Authentifié (ROLE_USER)
- Gestion du panier
- Création de commandes
- Modification du profil utilisateur

#### Accès Admin (ROLE_ADMIN)
- Gestion des produits
- Gestion des catégories
- Gestion des configurations
- Lecture des contacts
- Gestion des utilisateurs

## API Platform

### Configuration
La configuration principale d'API Platform se trouve dans `config/packages/api_platform.yaml`.

### Formats Supportés
- JSON-LD
- HAL
- JSON:API
- GraphQL
- OpenAPI (Swagger)

### Documentation Interactive
- Swagger UI : `/api/docs`
- ReDoc : `/api/docs.html`
- GraphiQL : `/api/graphql/graphiql`

### Fonctionnalités API Platform
- Filtres automatiques
- Pagination
- Validation automatique
- Sérialisation/Désérialisation
- HATEOAS
- OpenAPI/Swagger
- GraphQL

## Endpoints API

Les endpoints sont générés automatiquement par API Platform selon les attributs des entités.

### Format de Réponse Standard (JSON-LD)
```json
{
    "@context": "/api/contexts/Resource",
    "@id": "/api/resources/1",
    "@type": "Resource",
    "id": 1,
    "property": "value",
    // ... autres propriétés
}
```

### Ressources Principales
- `/api/users`
- `/api/products`
- `/api/categories`
- `/api/orders`
- `/api/customers`

### Opérations Disponibles
- Collection (`GET`, `POST`)
- Item (`GET`, `PUT`, `DELETE`)
- Sous-ressources
- Opérations personnalisées

## Base de Données

### Configuration
La base de données utilisée est une base MySQL/MariaDB existante nommée `eshop`. Cette base contient l'ensemble des données nécessaires au fonctionnement de l'application de vente en ligne.

### Structure des Tables

#### Cart (Panier)
```sql
CREATE TABLE cart (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME DEFAULT NULL
);
```

#### Cart Item (Élément du Panier)
```sql
CREATE TABLE cart_item (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cart_id INT NOT NULL,
    product_id INT NOT NULL,
    FOREIGN KEY (cart_id) REFERENCES cart(id),
    FOREIGN KEY (product_id) REFERENCES product(id)
);
```

#### Category (Catégorie)
```sql
CREATE TABLE category (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    is_active TINYINT(1) NOT NULL,
    description TEXT DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL
);
```

#### Category Attribute Types (Types d'attributs de catégorie)
```sql
CREATE TABLE category_attribute_types (
    category_id INT NOT NULL,
    variant_attribute_type_id INT NOT NULL,
    PRIMARY KEY (category_id, variant_attribute_type_id)
);
```

#### Contact (Messages de contact)
```sql
CREATE TABLE contact (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message LONGTEXT NOT NULL,
    created_at DATETIME NOT NULL,
    is_read TINYINT(1) DEFAULT NULL
);
```

#### Home Config (Configuration de la page d'accueil)
```sql
CREATE TABLE home_config (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    hero_title VARCHAR(255) NOT NULL,
    hero_subtitle VARCHAR(255) NOT NULL,
    hero_button_text VARCHAR(255) NOT NULL,
    hero_background_image VARCHAR(255) NOT NULL,
    featured_title VARCHAR(255) NOT NULL,
    newsletter_title VARCHAR(255) NOT NULL,
    newsletter_text VARCHAR(255) NOT NULL,
    is_active TINYINT(1) NOT NULL
);
```

#### Order (Commande)
```sql
CREATE TABLE `order` (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    customer_email VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(255) NOT NULL,
    shipping_address LONGTEXT NOT NULL,
    is_province TINYINT(1) NOT NULL,
    province VARCHAR(255) DEFAULT NULL,
    shipping_company VARCHAR(255) DEFAULT NULL,
    payment_method VARCHAR(20) DEFAULT NULL,
    payment_rate DOUBLE DEFAULT NULL,
    paid_amount DOUBLE DEFAULT NULL,
    payment_reference VARCHAR(255) DEFAULT NULL,
    payment_status VARCHAR(20) NOT NULL DEFAULT 'pending',
    updated_at DATETIME DEFAULT NULL
);
```

#### Order Item (Ligne de commande)
```sql
CREATE TABLE order_item (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DOUBLE NOT NULL,
    subtotal DOUBLE NOT NULL,
    FOREIGN KEY (order_id) REFERENCES `order`(id),
    FOREIGN KEY (product_id) REFERENCES product(id)
);
```

#### Product (Produit)
```sql
CREATE TABLE product (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description LONGTEXT NOT NULL,
    price DOUBLE NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    size VARCHAR(255) NOT NULL,
    color VARCHAR(255) NOT NULL,
    model VARCHAR(255) NOT NULL,
    materials LONGTEXT NOT NULL,
    availability TINYINT(1) NOT NULL,
    is_active TINYINT(1) NOT NULL,
    updated_at DATETIME DEFAULT NULL,
    is_trending TINYINT(1) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES category(id)
);
```

#### Product Image (Images du produit)
```sql
CREATE TABLE product_image (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    image VARCHAR(255) NOT NULL,
    is_main TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES product(id)
);
```

#### Product Variant (Variante de produit)
```sql
CREATE TABLE product_variant (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    sku VARCHAR(255) NOT NULL,
    price DOUBLE NOT NULL,
    stock INT NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id)
);
```

#### Product Variant Value (Valeurs des variantes de produit)
```sql
CREATE TABLE product_variant_value (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    variant_id INT NOT NULL,
    attribute_type_id INT NOT NULL,
    attribute_option_id INT NOT NULL,
    created_at DATETIME NOT NULL,
    updated_at DATETIME NOT NULL,
    FOREIGN KEY (variant_id) REFERENCES product_variant(id),
    FOREIGN KEY (attribute_type_id) REFERENCES category_attribute_types(variant_attribute_type_id),
    FOREIGN KEY (attribute_option_id) REFERENCES attribute_options(id)
);
```

#### Stock (Gestion des stocks)
```sql
CREATE TABLE stock (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL UNIQUE,
    quantity INT NOT NULL,
    alert_threshold INT NOT NULL,
    last_updated DATETIME NOT NULL,
    FOREIGN KEY (product_id) REFERENCES product(id)
);
```

#### Stock Movement (Mouvements de stock)
```sql
CREATE TABLE stock_movement (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    stock_id INT NOT NULL,
    FOREIGN KEY (stock_id) REFERENCES stock(id)
);
```

### Relations
- Un panier (`cart`) peut contenir plusieurs éléments (`cart_item`)
- Chaque élément du panier (`cart_item`) est lié à un produit
- Les catégories (`category`) peuvent contenir des produits
- Les catégories peuvent avoir plusieurs types d'attributs (`category_attribute_types`)
- La configuration de la page d'accueil (`home_config`) gère l'affichage de la landing page
- Les messages de contact (`contact`) sont stockés pour le suivi client
- Une commande (`order`) peut avoir plusieurs lignes de commande (`order_item`)
- Chaque ligne de commande est liée à un produit spécifique
- Les commandes contiennent les informations de livraison et de paiement
- Un produit (`product`) appartient à une catégorie
- Un produit peut avoir plusieurs images (`product_image`), dont une principale
- Un produit peut avoir plusieurs variantes (`product_variant`) avec des prix et stocks différents
- Les variantes de produit sont utilisées pour gérer les différentes options (tailles, couleurs, etc.)
- Les variantes de produit ont des valeurs spécifiques (`product_variant_value`) pour chaque type d'attribut
- Chaque produit a un stock associé (`stock`) avec un seuil d'alerte
- Les mouvements de stock (`stock_movement`) permettent de tracer les changements de quantité
- Le système de stock permet une gestion précise des inventaires et des alertes

### Mapping Doctrine
Les entités Symfony sont mappées sur les tables existantes en utilisant les attributs Doctrine et API Platform. Exemple :

```php
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\Table(name: 'category')]
#[ApiResource]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;
}
```

## Sécurité

- Authentification via JWT (LexikJWTAuthenticationBundle)
- Validation des données avec API Platform et Symfony Validator
- Protection CORS configurée via API Platform
- Rate Limiting natif API Platform
- Gestion des permissions via attributs API Platform

## Conventions de Code

### Style de Code
- PSR-12 pour le formatage du code
- Nommage en anglais pour les variables et fonctions
- Documentation PHPDoc pour les méthodes
- Utilisation des attributs PHP 8 pour API Platform et Doctrine

### Exemple d'Entity avec API Platform
```php
#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(),
        new Get(),
        new Put(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']]
)]
class Product
{
    // ...
}
```

### Commits
Format : `type(scope): description`
Types : feat, fix, docs, style, refactor, test, chore

### Branches
- main : production
- develop : développement
- feature/* : nouvelles fonctionnalités
- hotfix/* : corrections urgentes

## Déploiement

1. Vérification des tests
```bash
php bin/phpunit
```

2. Migration de la base de données
```bash
php bin/console doctrine:migrations:migrate
```

3. Mise à jour des dépendances
```bash
composer update
```

4. Nettoyage du cache
```bash
php bin/console cache:clear
```

5. Réchauffement du cache API Platform
```bash
php bin/console api:openapi:export
```

## Monitoring et Logs

- Logs d'erreurs : `var/log/`
- Monitoring des performances via New Relic
- Surveillance des erreurs avec Sentry
- Métriques API Platform dans Symfony Profiler

## Environnements

- Développement : dev.api.eshopbyvalsue.com
- Staging : staging.api.eshopbyvalsue.com
- Production : api.eshopbyvalsue.com 