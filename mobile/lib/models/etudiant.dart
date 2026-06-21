class Etudiant {
  const Etudiant({
    this.id,
    required this.matricule,
    required this.nom,
    required this.prenom,
    required this.sexe,
    this.dateNaissance,
    this.lieuNaissance,
    this.email,
    this.telephone,
    this.adresse,
  });

  final int? id;
  final String matricule;
  final String nom;
  final String prenom;
  final String sexe;
  final String? dateNaissance;
  final String? lieuNaissance;
  final String? email;
  final String? telephone;
  final String? adresse;

  String get nomComplet => '$nom $prenom';

  factory Etudiant.fromJson(Map<String, dynamic> json) {
    return Etudiant(
      id: json['id'] as int?,
      matricule: json['matricule'] as String,
      nom: json['nom'] as String,
      prenom: json['prenom'] as String,
      sexe: json['sexe'] as String,
      dateNaissance: json['date_naissance'] as String?,
      lieuNaissance: json['lieu_naissance'] as String?,
      email: json['email'] as String?,
      telephone: json['telephone'] as String?,
      adresse: json['adresse'] as String?,
    );
  }

  Map<String, dynamic> toJson() => {
        'matricule': matricule,
        'nom': nom,
        'prenom': prenom,
        'sexe': sexe,
        'date_naissance': dateNaissance,
        'lieu_naissance': lieuNaissance,
        'email': email,
        'telephone': telephone,
        'adresse': adresse,
      };

  Etudiant copyWith({
    int? id,
    String? matricule,
    String? nom,
    String? prenom,
    String? sexe,
    String? dateNaissance,
    String? lieuNaissance,
    String? email,
    String? telephone,
    String? adresse,
  }) {
    return Etudiant(
      id: id ?? this.id,
      matricule: matricule ?? this.matricule,
      nom: nom ?? this.nom,
      prenom: prenom ?? this.prenom,
      sexe: sexe ?? this.sexe,
      dateNaissance: dateNaissance ?? this.dateNaissance,
      lieuNaissance: lieuNaissance ?? this.lieuNaissance,
      email: email ?? this.email,
      telephone: telephone ?? this.telephone,
      adresse: adresse ?? this.adresse,
    );
  }
}
