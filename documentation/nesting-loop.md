# Les boucles imbriquées

## Objectif : Comprendre les boucles imbriquées avec ACF + Timber

Tu veux afficher des données structurées (comme des cartes, des étapes, des produits avec détails, etc.) où chaque élément contient lui-même une liste d’éléments → c’est là qu’interviennent les boucles imbriquées.

---

### A. ACF Repeater (Advanced Custom Fields)

C’est un champ qui te permet de créer plusieurs blocs répétables dans l’admin WordPress.

Exemple : Tu veux afficher une liste de sections, et dans chaque section, une liste de sous-éléments (ex: une galerie d’images, une liste de fonctionnalités, etc.).

→ Tu crées un champ repeater appelé sections, et dedans, un sous-champ repeater appelé items.

### B. Timber + Twig

Timber permet d’utiliser Twig (un moteur de templates) dans WordPress. C’est plus propre, plus lisible, et plus sécurisé que du PHP brut.

```twig
{% for item in items %}
    {{ item.titre }}
{% endfor %}
```

### Structure ACF (exemple concret)

Imaginons que tu as créé :

   -  Un champ Repeater : sections
       -  Sous-champ texte : titre_section
       -  Sous-champ Repeater : items
           -  Sous-champ texte : nom_item
           -  Sous-champ image : icone

> 1 section → plusieurs items → chaque item a un nom + une icône

 ### Dans ton contrôleur PHP

 Tu récupères les données avec Timber :

```php
<?php
$context = Timber::context();

// Récupère le champ repeater 'sections' de la page courante
$context['sections'] = get_field('sections');

Timber::render('page.twig', $context);
```

### Dans un template Twig (*.twig)

Tu vas faire **une boucle dans une boucle** → c’est ça, une boucle imbriquée !

```twig
{# Boucle principale : les sections #}
{% for section in sections %}
    <section>
        <h2>{{ section.titre_section }}</h2>

        {# Boucle imbriquée : les items de cette section #}
        <ul>
        {% for item in section.items %}
            <li>
                <img src="{{ item.icone.url }}" alt="{{ item.icone.alt }}">
                <span>{{ item.nom_item }}</span>
            </li>
        {% endfor %}
        </ul>

    </section>
{% endfor %}
```

### 🔄 Comment ça marche ?

Première boucle : ```for section in sections```
→ Pour chaque section dans le repeater principal, tu affiches son titre.

À l’intérieur, tu lances une deuxième boucle : ```for item in section.items```
→ Tu parcours les items qui sont à l’intérieur de la section courante.

Tu affiches les données de chaque item (nom, icône…).

---

### Avantages de cette méthode

✅ Propre et lisible avec Twig
✅ Flexible : tu peux ajouter autant de niveaux que tu veux (même 3 ou 4 !)
✅ Géré visuellement dans l’admin WordPress avec ACF
✅ Séparation logique (PHP) / affichage (Twig)

### Pièges courants

❌ Oublier de vérifier si le repeater existe → toujours faire un if :

```twig
{% if sections %}
    {% for section in sections %}
        ...
    {% endfor %}
{% endif %}
```

❌ Confondre le nom du champ ACF avec la variable Twig → **vérifie bien les noms** !

Happy looping :)
