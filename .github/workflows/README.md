# Workflows GitHub Actions

Ce répertoire contient les workflows d'intégration continue pour le module FlexPay.

## Workflow de Tests (`tests.yml`)

### Déclencheurs
- Push sur les branches `main` et `develop`
- Pull requests vers les branches `main` et `develop`

### Jobs

#### 1. Tests (`test`)
- **Matrice de tests** : PHP 7.2, 7.3, 7.4, 8.0, 8.1, 8.2
- **Extensions PHP requises** : curl, json, pdo
- **Étapes** :
  - Validation du fichier composer.json
  - Installation des dépendances avec cache
  - Exécution des tests unitaires
  - Génération du rapport de couverture (PHP 8.1 uniquement)
  - Upload vers Codecov

#### 2. Qualité du Code (`code-quality`)
- **Version PHP** : 8.1
- **Vérifications** :
  - Syntaxe PHP
  - Audit de sécurité des dépendances

### Configuration

#### Cache Composer
Les dépendances Composer sont mises en cache pour accélérer les builds.

#### Couverture de Code
La couverture de code est générée uniquement pour PHP 8.1 et uploadée vers Codecov.

#### Audit de Sécurité
Vérification automatique des vulnérabilités dans les dépendances.

### Badges de Statut

Ajoutez ces badges à votre README principal :

```markdown
![Tests](https://github.com/holsonmp/flexpay/workflows/Tests/badge.svg)
[![codecov](https://codecov.io/gh/holsonmp/flexpay/branch/main/graph/badge.svg)](https://codecov.io/gh/holsonmp/flexpay)
```

### Personnalisation

Pour modifier la configuration :

1. **Ajouter des versions PHP** : Modifiez la matrice dans `strategy.matrix.php-version`
2. **Changer les branches** : Modifiez les déclencheurs `on.push.branches` et `on.pull_request.branches`
3. **Ajouter des outils** : Ajoutez des étapes dans le job `code-quality`

### Prérequis

- Repository GitHub public ou privé avec Actions activées
- Fichiers `composer.json` et `phpunit.xml` configurés
- Tests PHPUnit dans le répertoire `tests/`