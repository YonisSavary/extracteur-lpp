# lpp-to-sql

Cet outil est capable de lire les données depuis le fichier NX téléchargeable sur le [site de la sécurité sociale](http://www.codage.ext.cnamts.fr/codif/tips//telecharge/index_tele.php?p_site=AMELI)(fichier tarifaire total LPPTOT703)

## Utilisation

Lancez d'abord le script

```bash
php main.php
```

si tout s'est bien passé, un fichier devrait être créé dans `./tmp/out.sql`


## Schema / Contribuer

Le projet contient un convertisseur SQL basique, qui permet de convertir les codes, les prix ainsi que les (In)compatibilités. 

Celui-ci se trouve dans `/SQL/Basic`, il n'est pas parfait, mais contient l'essentiel pour vos productions.

### Créer un convertisseur

Si vous souhaitez ajouter un convertisseur SQL, créez-le dans le dossier `SQL`,
celui-ci devrat implémenter `Source\Interfaces\SQLWriterInterface`, cette interface contient

```php
public function write(array $object, string $class);
```

Cette méthode prend un objet (qui est récupéré depuis un enregistrement du fichier NX, et la classe type associée à l'objet (`\Source\Types\CodeDescription` par exemple))

Exemple: pour un objet associé à la classe `CodeEnd`, 
`$object` sera un tableau associatif contenant ces clés :
- `Type d'enregistrement`
- `Séquence`
- `Rubrique`
- `Nombre d'enregistrements`
- `Inutilisé`


Vous pouvez ensuite utiliser votre convertisseur avec le paramètre `writer`
```
php main.php --writer=SQL\Basic\BasicSQLWriter
```