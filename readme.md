# Documentation du Module FlexPay pour WHMCS

## Sommaire

- [Présentation](#présentation)  
- [Configuration Requise](#configuration-requise)  
- [Installation](#installation)  
- [Configuration](#configuration)  
- [Tests](#tests)  
- [Support](#support)  
- [Journalisation des Erreurs](#journalisation-des-erreurs)  
- [Dépannage Courant](#dépannage-courant)

---

## Présentation

Le module **FlexPay** pour **WHMCS** permet d'intégrer la passerelle de paiement FlexPay à votre système de facturation. Il supporte les moyens de paiement suivants :

- Visa  
- MasterCard  
- PayPal

---

## Configuration Requise

- WHMCS version **7.0** ou supérieure  
- PHP **7.2** ou supérieur  
- Extension PHP **cURL** activée  
- Compte FlexPay actif avec identifiants API (Merchant Code + API Token)

---

## Installation

1. **Téléchargez les fichiers du module** (`flexpay.php`, `callback/flexpay.php`)
2. **Copiez les fichiers** dans votre installation WHMCS :

   - `modules/gateways/flexpay.php`
   - `modules/gateways/callback/flexpay.php`

3. **Activez le module dans WHMCS** :

   - Accédez à `Configuration > Paramètres système > Méthodes de paiement`
   - Trouvez **FlexPay** dans la liste
   - Cliquez sur **Activer**

---

## Configuration

Dans l'interface d'administration WHMCS, configurez les paramètres suivants :

| Paramètre      | Description                              |
|----------------|------------------------------------------|
| Merchant Code  | Votre identifiant marchand FlexPay       |
| API Token      | Votre clé secrète JWT FlexPay            |
| Mode Test      | Activer ou désactiver l’environnement de test |

---

## Tests

### Tests Unitaires

Les tests unitaires sont disponibles dans le dossier `tests`. Pour les exécuter :

```bash
phpunit --bootstrap vendor/autoload.php tests/

```
### Structure des Tests

    - testPaymentFormGeneration()

    - testCallbackHandling()

    - testInvalidCredentials()

### Exemples de Résultats

    - Paiement accepté → statut Success

    - Paiement refusé → statut Failed

    - Signature invalide → statut Error

## Support

    - Documentation API FlexPay : https://docs.flexpay.cd

    - Support technique : support@flexpay.cd

    - GitHub : https://github.com/holsonmp/flexpay