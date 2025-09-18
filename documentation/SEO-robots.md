# ROBOTS.txt

> Un peu comme la dynamite, ce fichier doit être manipulé avec beaucoup de précaution.
> Il permet de donner des instructions aux robots d'indexation des moteurs de recherche (Google, Bing, etc.) sur les pages qu'ils peuvent ou ne peuvent pas indexer.
> Il est crucial de bien comprendre son fonctionnement pour éviter de bloquer accidentellement l'accès à des parties importantes de votre site.
> Il est recommandé de tester soigneusement les règles définies dans ce fichier avant de le mettre en production.
>
> *Note :* Ce fichier doit être placé à la racine de votre site web pour être pris en compte par les robots d'indexation.

## Structure du fichier

Il y a deux façons de procéder :

- utiliser un plugin (YOAST).
- le créer manuellement.

### Methode plugin, YOAST SEO

De nombreux plugins SEO pour les CMS populaires (comme WordPress, Drupal, Joomla, etc.) offrent une interface conviviale pour gérer le fichier `robots.txt` sans avoir à le créer manuellement.
Par exemple, le plugin Yoast SEO pour WordPress permet de générer et de modifier facilement le fichier `robots.txt` directement depuis le tableau de bord de WordPress. Il suffit d'aller dans la section "Outils" du plugin, puis de sélectionner "Éditeur de fichiers" pour accéder au fichier `robots.txt` et le modifier selon vos besoins.

### Methode manuelle

Pour créer un fichier `robots.txt` manuellement, suivez ces étapes :

1. Ouvrez un éditeur de texte (comme Notepad, VSCode, Sublime Text, etc.).
2. Ajoutez les directives souhaitées (voir la section suivante pour les principales directives).
3. Enregistrez le fichier sous le nom `robots.txt`.
4. Téléchargez le fichier à la racine de votre site web (par exemple, `https://www.votresite.com/robots.txt`).
5. Testez le fichier en utilisant des outils en ligne comme le "Robots.txt Tester" de Google Search Console pour vous assurer qu'il fonctionne comme prévu.
6. Surveillez régulièrement les performances de votre site dans les moteurs de recherche pour vous assurer que les règles définies dans le fichier `robots.txt` n'affectent pas négativement l'indexation de votre site.
7. Mettez à jour le fichier `robots.txt` si nécessaire, en fonction des changements apportés à votre site ou des nouvelles directives des moteurs de recherche.
8. Informez les moteurs de recherche des modifications apportées au fichier `robots.txt` en soumettant à nouveau le fichier via la Google Search Console ou d'autres outils similaires.

## Principales directives

Les deux règles principales se nomment :

**User-agent**: désigne le nom d'un robot de moteur de recherche auquel la règle s'applique. Le caractère `*` est un joker qui s'applique à tous les robots.
**Disallow**: désigne un répertoire ou une page, relatif au domaine racine, qui ne doit pas être exploré par le user-agent. Rappelez-vous que, par défaut, un robot peut explorer une page ou un répertoire non-bloqué par une règle Disallow.

Un fichier `robots.txt` peut-etre composé de **directives** qui indiquent aux robots comment interagir avec votre site.
Voici une liste non-exhaustive des  directives :

- `Allow` : Indique les pages ou répertoires que le robot est autorisé à visiter (utile pour autoriser des sous-répertoires dans un répertoire interdit).
- `Sitemap` : Indique l'emplacement du fichier sitemap de votre site, ce qui aide les moteurs de recherche à trouver toutes les pages de votre site.
- `Crawl-delay` : Spécifie le délai (en secondes) entre les requêtes du robot pour éviter de surcharger le serveur.
- `Host` : Indique le nom de domaine préféré pour le site (utile pour les sites avec plusieurs domaines).
- `Noindex` : Indique aux robots de ne pas indexer une page spécifique (notez que cette directive n'est pas officiellement reconnue par tous les moteurs de recherche).
- `Clean-param` : Utilisé pour indiquer aux moteurs de recherche de ne pas indexer les URL avec certains paramètres de requête.
- `Request-rate` : Spécifie le nombre maximum de requêtes qu'un robot peut faire dans un intervalle de temps donné.
- `Visit-time` : Indique les heures pendant lesquelles un robot est autorisé à visiter le site.
- `Disallow: /` : Bloque l'accès à l'ensemble du site.
- `Allow: /` : Autorise l'accès à l'ensemble du site.
- `Disallow: /private/` : Bloque l'accès au répertoire `/private/` et à tout son contenu.
- `Allow: /public/` : Autorise l'accès au répertoire `/public/ ` et à tout son contenu.
- `Disallow: /temp/` : Bloque l'accès au répertoire `/temp /` et à tout son contenu.
- `Allow: /public/images/` : Autorise l'accès au répertoire `/public/images/` et à tout son contenu.
- `Disallow: /admin/` : Bloque l'accès au répertoire `/admin/` et à tout son contenu.
- `Allow: /public/css/` : Autorise l'accès au répertoire `/public/css/` et à tout son contenu.
- `Disallow: /cgi-bin/` : Bloque l'accès au répertoire `/cgi-bin/` et à tout son contenu.
- `Allow: /public/js/` : Autorise l'accès au répertoire `/public/js/` et à tout son contenu.
- `Disallow: /scripts/` : Bloque l'accès au répertoire `/scripts/` et à tout son contenu.
- `Allow: /public/fonts/` : Autorise l'accès au répertoire `/public/fonts/` et à tout son contenu.
- `Disallow: /config/` : Bloque l'accès au répertoire `/config/` et à tout son contenu.
- `Allow: /public/videos/` : Autorise l'accès au répertoire `/public/videos/` et à tout son contenu.
- `Disallow: /logs/` : Bloque l'accès au répertoire `/logs/` et à tout son contenu.
- `Allow: /public/docs/` : Autorise l'accès au répertoire `/public/docs/` et à tout son contenu.
- `Disallow: /backup/` : Bloque l'accès au répertoire `/backup/` et à tout son contenu.
- `Allow: /public/api/` : Autorise l'accès au répertoire `/public/api/` et à tout son contenu.

aller plus loin dans la documentation officielle : [https://developers.google.com/search/docs/advanced/robots/intro?hl=fr](https://developers.google.com/search/docs/advanced/robots/intro?hl=fr)
Un article sur le sujet : [https://www.robotstxt.org/robotstxt.html](https://www.robotstxt.org/robotstxt.html)
Un article sur les robots et WordPress https://wpmarmite.com/robots-txt-wordpress/
Un article de la doc officiellle de WordPress : https://wordpress.org/documentation/article/search-engine-optimization/


#### *Happy coding* 🤖
