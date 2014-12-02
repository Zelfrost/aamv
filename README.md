Site internet de l'AAMV
=======================

Voici le code source du site internet de l'aamv (Association des Assistantes Maternelles de Villeneuve d'ascq).
Pour faire tourner le projet chez vous, rien de plus simple :

```bash
git clone git@github.com:Zelfrost/aamv.git
cd aamv
bin/install
```

Vous pouvez ensuite lancer un serveur php via :

```bash
php app/console server:run
```

Vous pourrez ainsi accéder à l'application via le port 8000 de votre machine :
```
http://localhost:8000/
```