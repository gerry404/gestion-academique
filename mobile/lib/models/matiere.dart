class Matiere {
  const Matiere({
    this.id,
    required this.code,
    required this.libelle,
    required this.coefficient,
  });

  final int? id;
  final String code;
  final String libelle;
  final int coefficient;

  factory Matiere.fromJson(Map<String, dynamic> json) {
    return Matiere(
      id: json['id'] as int?,
      code: json['code'] as String,
      libelle: json['libelle'] as String,
      coefficient: (json['coefficient'] as num).toInt(),
    );
  }

  Map<String, dynamic> toJson() => {
        'code': code,
        'libelle': libelle,
        'coefficient': coefficient,
      };
}
