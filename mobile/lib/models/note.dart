import 'etudiant.dart';
import 'matiere.dart';

class Note {
  const Note({
    this.id,
    required this.etudiantId,
    required this.matiereId,
    required this.type,
    required this.valeur,
    this.etudiant,
    this.matiere,
  });

  final int? id;
  final int etudiantId;
  final int matiereId;
  final String type;
  final double valeur;
  final Etudiant? etudiant;
  final Matiere? matiere;

  factory Note.fromJson(Map<String, dynamic> json) {
    return Note(
      id: json['id'] as int?,
      etudiantId: (json['etudiant_id'] as num).toInt(),
      matiereId: (json['matiere_id'] as num).toInt(),
      type: json['type'] as String,
      valeur: (json['valeur'] as num).toDouble(),
      etudiant: json['etudiant'] != null
          ? Etudiant.fromJson(json['etudiant'] as Map<String, dynamic>)
          : null,
      matiere: json['matiere'] != null
          ? Matiere.fromJson(json['matiere'] as Map<String, dynamic>)
          : null,
    );
  }

  Map<String, dynamic> toJson() => {
        'etudiant_id': etudiantId,
        'matiere_id': matiereId,
        'type': type,
        'valeur': valeur,
      };
}
