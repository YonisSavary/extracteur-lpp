# extracteur-lpp \[FR]

Cet outil est capable de lire les données depuis le fichier NX téléchargeable sur le [site de la sécurité sociale](http://www.codage.ext.cnamts.fr/codif/tips//telecharge/index_tele.php?p_site=AMELI) (fichier tarifaire total LPPTOT703)

## Utilisation

Lancez d'abord le script

```bash
php bin/download-file
php bin/parse --input=LPPTOT<n>
```

si tout s'est bien passé, un fichier devrait être créé dans `./tmp/BasicSQLWriter.sql`

### Créer un fichier JSON

```php
php bin/parse --input=LPPTOT754 --writer=YonisSavary\\ExtracteurLPP\\Adapters\\JSONWriter\\JSONWriter
```

### Utilisation en code

```php
$writer = new JSONWriter($outDirectory);
$reader = FileReader::readNXFile($sourceFile, $writer);

$outputFile = $writer->getPath();
```

## Schema / Contribuer

Le projet contient un convertisseur SQL basique, qui permet de convertir les codes, les prix ainsi que les (In)compatibilités.

Celui-ci se trouve dans [`/Adapters/BasicSQLWriter`](./src/Adapters/BasicSQLWriter/), il n'est pas parfait, mais contient l'essentiel pour vos productions.

### Créer un convertisseur

Si vous souhaitez ajouter un convertisseur,
celui-ci devrat implémenter [`Interfaces\DataAdapterInterface`](./src/Interfaces/DataAdapterInterface.php), cette interface contient

```php
public function __construct(string $outPath);
public function write(array $object, string $class);
```

Cette méthode prend un objet (qui est récupéré depuis un enregistrement du fichier NX, et la classe type associée à l'objet (`\Source\Types\CodeDescription` par exemple))

Exemple: pour un objet associé à la classe [`CodeEnd`](./src/RecordTypes/CodeEnd.php),
`$object` sera un tableau associatif contenant ces clés :
- `Type d'enregistrement`
- `Séquence`
- `Rubrique`
- `Nombre d'enregistrements`
- `Inutilisé`


Vous pouvez ensuite utiliser votre convertisseur avec le paramètre `writer`
```
php bin/parse --writer=SQL\\Basic\\BasicSQLWriter
```