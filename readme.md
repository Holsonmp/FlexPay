# Documentation du Module FlexPay pour WHMCS

## Sommaire

- [Présentation](#présentation)
- [Configuration Requise](#configuration-requise)
- [Installation](#installation)
- [Configuration](#configuration)
- [Utilisation](#utilisation)
- [Tests](#tests)
- [Sécurité](#sécurité)
- [Support & Contact](#support--contact)
- [FAQ & Dépannage](#faq--dépannage)

---

## Présentation

Le module **FlexPay** pour **WHMCS** est une solution de paiement complète offrant :

- Support multi-devises
- Interface responsive
- Tableau de bord détaillé
- Transactions sécurisées

### Moyens de paiement pris en charge :
- Visa
- MasterCard
- Mobile Money
- PayPal

---

## Configuration Requise

### Prérequis Techniques
- WHMCS version **7.0** ou supérieure
- PHP **7.2** ou supérieur
- Extensions PHP requises :
  - cURL
  - PDO
  - JSON
- SSL/HTTPS obligatoire

### Prérequis Compte
- Compte FlexPay actif
- Merchant Code (fourni par FlexPay)
- API Token (généré dans votre espace FlexPay)

---

## Installation

### 1. Préparation
```bash
mkdir -p modules/gateways/callback/
```

### 2. Installation des Fichiers
1. Téléchargez la dernière version depuis GitHub
2. Copiez les fichiers :
   ```bash
   cp flexpay.php /chemin/vers/whmcs/modules/gateways/
   cp callback/flexpay.php /chemin/vers/whmcs/modules/gateways/callback/
   ```

### 3. Activation
1. Accédez à `Configuration > Système > Méthodes de paiement`
2. Trouvez **FlexPay** dans la liste
3. Cliquez sur **Activer**

---

## Configuration

### Paramètres Principaux

| Paramètre      | Description                              | Obligatoire |
|----------------|------------------------------------------|-------------|
| Merchant Code  | Identifiant marchand FlexPay            | Oui         |
| API Token      | Clé secrète JWT FlexPay                 | Oui         |
| Mode Test      | Environnement de test/production        | Non         |

### Configuration Avancée
```php
define('FLEXPAY_DEBUG', true);    // Active les logs détaillés
define('FLEXPAY_TIMEOUT', 30);    // Timeout des requêtes (secondes)
```

---

## Utilisation

### Processus de Paiement
1. Sélection de FlexPay comme moyen de paiement
2. Redirection vers la page sécurisée FlexPay
3. Choix du moyen de paiement par le client
4. Validation et retour automatique sur WHMCS

### Statuts des Transactions
- `success` : Paiement réussi
- `pending` : En attente
- `failed` : Échec
- `cancelled` : Annulé

---

## Tests

### Tests Unitaires
```bash
# Installation des dépendances
composer require --dev phpunit/phpunit

# Exécution des tests
./vendor/bin/phpunit tests/FlexPayTest.php
```

### Tests d'Intégration
```bash
./vendor/bin/phpunit tests/FlexPayIntegrationTest.php
```

### Scénarios de Test
- Paiement réussi
- Paiement refusé
- Timeout de session
- Erreur de validation

---

## Sécurité

### Recommandations
- Utilisez toujours HTTPS
- Validez toutes les entrées
- Configurez les webhooks
- Surveillez les logs régulièrement

### Validation des Transactions
```php
// Exemple de vérification de signature
if (hash_equals($expectedSignature, $receivedSignature)) {
    // Transaction valide
}
```

---

## Support & Contact

- **Documentation API** : [https://docs.flexpay.cd](https://docs.flexpay.cd)
- **Support Technique** : support@flexpay.cd
- **GitHub** : [https://github.com/holsonmp/flexpay](https://github.com/holsonmp/flexpay)

---

## FAQ & Dépannage

### Problèmes Fréquents

1. **La page de paiement ne s'affiche pas**
   - Vérifiez la configuration SSL
   - Validez les paramètres API
   - Consultez les logs PHP

2. **Erreur de validation**
   - Vérifiez le Merchant Code
   - Validez l'API Token
   - Contrôlez le format des données

3. **Callback non reçu**
   - Vérifiez l'URL de callback
   - Contrôlez les paramètres firewall
   - Consultez les logs système

### Logs
Les logs sont stockés dans :
```
/modules/gateways/flexpay/logs/
```