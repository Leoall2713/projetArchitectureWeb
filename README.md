# projet d'architecture et application Web

## 1. Les tables : 
Pour gérer nos réservations nous avons décidé de créer 5 tables.

### A. Enseignants
Une premère table Enseignants pour gérer les enseignants de l'université. On a alors leur nom, leur prénom, leur email ainsi qu'un identifiant qui leur est propre.

### B. Matières
Une deuxième table Matières pour gérer les matières enseignées à l'université. On a ici le nom de la matière, la durée en minute, ainsi qu'un identifiant pour chaque matière différente.

### C. Promotions
Une troisième table promotions pour gérer les différentes promotions de l'université. On a ici le niveau de la promotion (Licence 1, Master 2...), l'intitulé de la formation (Mathématiques, MIASHS...), le nombre d'élèves présents dans la promotion ainsi qu'un identifiant pour chaque promotion.

### D. Salles
Une quatrième table Salles pour gérer les différentes salles de l'université. On a ici le nom de la salle, la capacité de la salle ainsi qu'un identifiant pour chaque salle.

### E. Réservations
Une cinquième table Réservations pour gérer les réservations des salles. On a ici un créneau horaire avec une date, une heure de début et une heure de fin, on récupère aussi tous les identifiants des tables précédente afin d'affecter à chaque réservation, un enseignant, une matière, une salle et une promotion, ainsi qu'un identifiant pour chaque salle.

## 2. Les conditions pour une réservations (ReservationsController).
On a mit plusieurs conditions dans ReservationsController pour que la réservation soit valide.

### A. Vérifier les heures
On va d'abord vérifier que l'heure de début est inférieur à celle de fin.

### B. Vérifier la durée
On va ensuite vérifier que la réservation est supérieur à 1. On a décidé que la réservation pour une salle pour moins d'une heure n'était pas possible.

### C. Vérifier que tout soit disponible
On vérifie que tout soit disponible au créneau choisit. C'est-à-dire que l'enseignant, la promotion et la salle sont disponibles pour le créneau choisit et pas affectés à un autre créneau équivalent ou qui chevauche celui-ci.

### D. Capacité des salles

On vérifie que la salle peut accueillir la promotion choisit. C'est à dire que la capacité de la salle est supérieur ou égale au nombre d'étudiants de la promotion.

### E. Durée de la matière

On vérifie que la durée de la matière corréspond bien au créneau choisi.

### F. Horaire ouverture de l'université

L'université ouvre ses portes à 08h00 et les ferme à 20h00, donc de même pour les salles. On va donc vérifier que le créneau choisi ne commence pas avant 08h00 et ne fini pas après 20h00.

### G. Envoie du formulaire

Si toutes les conditions sont remplis, on ajoute alors une nouvelle réservations.

## 3. Affichage et front

### A. Bootstrap
Pour la partie front nous avons choisi d'utiliser bootstrap

### B. Affichage des réservations
Nous avons donc décidé d'afficher les réservations en détail, c'est a dire la date, l'heure de début, l'heure de fin, le nom et prénom de l'enseignant, le niveau de la promotion et l'intitulé de la formation, le nom de la matière et le nom de la salle.

### Afficher selon la salle ou la promotion

Nous avons ajouté un formulaire pour chosiir d'afficher les créneaux réservé pour les promotions ainsi que pour les salles.

## 4. Problèmes rencontrés

### A. Problème de date
Pour certaines dates, les conditions ne marche pas. Malgrés de longues recherches nous n'avons pas réussi à identifier le problèmes.



