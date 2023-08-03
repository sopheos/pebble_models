# Pebble/Models

Librairie pour gerer des modèles.

## ModelInterface

Représentation d'une donnée sous forme d'objet.
Les données sont en propriétés publiques.

L'objet peut être transformé en chaîne JSON. Seul les propriétés publiques déclarées
seront représentés dans le document JSON.

Méthodes :


- `init(): static` : Valeurs par défaut (appelé par le constructeur) 
- `import(array $data = []): static` : importe des données sous forme de tableau
- `export(): array` : exporte des données sous forme de tableau
- `properties(): array` : Liste les propriétés publiques déclarées

## AdapterInterface

Couche d’accès aux données qui effectue un transfert bidirectionnel de données entre un stockage de données et une représentation de données en mémoire.

Méthodes :

- `encode(array $input): array` Encode les données depuis la mémoire vers le stockage
- `decode(array $input): array` Décode les données depuis le stockage vers la mémoire

Méthode statique :

- `unique(array $rows, string $property): array` Retourne les valeurs uniques d'une colonne d'un tableau d'entrées.
