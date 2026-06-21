import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:provider/provider.dart';

import '../../models/etudiant.dart';
import '../../providers/etudiant_provider.dart';

class EtudiantFormPage extends StatefulWidget {
  const EtudiantFormPage({super.key, this.etudiant});

  final Etudiant? etudiant;

  @override
  State<EtudiantFormPage> createState() => _EtudiantFormPageState();
}

class _EtudiantFormPageState extends State<EtudiantFormPage> {
  final _formKey = GlobalKey<FormState>();
  late final TextEditingController _matricule;
  late final TextEditingController _nom;
  late final TextEditingController _prenom;
  late final TextEditingController _dateNaissance;
  late final TextEditingController _lieuNaissance;
  late final TextEditingController _email;
  late final TextEditingController _telephone;
  late final TextEditingController _adresse;
  String _sexe = 'M';
  bool _submitting = false;

  bool get _isEdit => widget.etudiant != null;

  @override
  void initState() {
    super.initState();
    final e = widget.etudiant;
    _matricule = TextEditingController(text: e?.matricule ?? '');
    _nom = TextEditingController(text: e?.nom ?? '');
    _prenom = TextEditingController(text: e?.prenom ?? '');
    _dateNaissance = TextEditingController(text: e?.dateNaissance ?? '');
    _lieuNaissance = TextEditingController(text: e?.lieuNaissance ?? '');
    _email = TextEditingController(text: e?.email ?? '');
    _telephone = TextEditingController(text: e?.telephone ?? '');
    _adresse = TextEditingController(text: e?.adresse ?? '');
    _sexe = e?.sexe ?? 'M';
  }

  @override
  void dispose() {
    _matricule.dispose();
    _nom.dispose();
    _prenom.dispose();
    _dateNaissance.dispose();
    _lieuNaissance.dispose();
    _email.dispose();
    _telephone.dispose();
    _adresse.dispose();
    super.dispose();
  }

  String? _trimOrNull(String value) {
    final v = value.trim();
    return v.isEmpty ? null : v;
  }

  Future<void> _submit() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => _submitting = true);

    final etudiant = Etudiant(
      id: widget.etudiant?.id,
      matricule: _matricule.text.trim(),
      nom: _nom.text.trim(),
      prenom: _prenom.text.trim(),
      sexe: _sexe,
      dateNaissance: _trimOrNull(_dateNaissance.text),
      lieuNaissance: _trimOrNull(_lieuNaissance.text),
      email: _trimOrNull(_email.text),
      telephone: _trimOrNull(_telephone.text),
      adresse: _trimOrNull(_adresse.text),
    );

    final provider = context.read<EtudiantProvider>();
    final ok = _isEdit
        ? await provider.update(widget.etudiant!.id!, etudiant)
        : await provider.create(etudiant);

    if (!mounted) return;
    setState(() => _submitting = false);

    if (ok) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(_isEdit ? 'Etudiant modifie.' : 'Etudiant ajoute.'),
        ),
      );
      context.pop();
    } else {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(provider.error ?? 'Une erreur est survenue.')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    final isWide = MediaQuery.sizeOf(context).width >= 800;

    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        backgroundColor: Colors.white,
        foregroundColor: const Color(0xFF1E293B),
        elevation: 0,
        shape: const Border(bottom: BorderSide(color: Color(0xFFE2E8F0))),
        title: Text(_isEdit ? 'Modifier un etudiant' : 'Ajouter un etudiant'),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(24),
        child: Center(
          child: ConstrainedBox(
            constraints: const BoxConstraints(maxWidth: 700),
            child: Container(
              padding: const EdgeInsets.all(24),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(12),
                border: Border.all(color: const Color(0xFFE2E8F0)),
              ),
              child: Form(
                key: _formKey,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.stretch,
                  children: [
                    _Field(
                      controller: _matricule,
                      label: 'Matricule *',
                      validator: _required,
                    ),
                    _Pair(
                      isWide: isWide,
                      first: _Field(
                        controller: _nom,
                        label: 'Nom *',
                        validator: _required,
                      ),
                      second: _Field(
                        controller: _prenom,
                        label: 'Prenom *',
                        validator: _required,
                      ),
                    ),
                    _Pair(
                      isWide: isWide,
                      first: _SexeDropdown(
                        value: _sexe,
                        onChanged: (v) => setState(() => _sexe = v),
                      ),
                      second: _Field(
                        controller: _dateNaissance,
                        label: 'Date de naissance (AAAA-MM-JJ)',
                        keyboardType: TextInputType.datetime,
                      ),
                    ),
                    _Field(
                      controller: _lieuNaissance,
                      label: 'Lieu de naissance',
                    ),
                    _Pair(
                      isWide: isWide,
                      first: _Field(
                        controller: _email,
                        label: 'Email',
                        keyboardType: TextInputType.emailAddress,
                      ),
                      second: _Field(
                        controller: _telephone,
                        label: 'Telephone',
                        keyboardType: TextInputType.phone,
                      ),
                    ),
                    _Field(
                      controller: _adresse,
                      label: 'Adresse',
                    ),
                    const SizedBox(height: 8),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.end,
                      children: [
                        TextButton(
                          onPressed:
                              _submitting ? null : () => context.pop(),
                          child: const Text('Annuler'),
                        ),
                        const SizedBox(width: 8),
                        FilledButton(
                          onPressed: _submitting ? null : _submit,
                          child: _submitting
                              ? const SizedBox(
                                  width: 18,
                                  height: 18,
                                  child: CircularProgressIndicator(
                                    strokeWidth: 2,
                                    color: Colors.white,
                                  ),
                                )
                              : Text(_isEdit ? 'Enregistrer' : 'Ajouter'),
                        ),
                      ],
                    ),
                  ],
                ),
              ),
            ),
          ),
        ),
      ),
    );
  }

  String? _required(String? value) {
    if (value == null || value.trim().isEmpty) {
      return 'Champ obligatoire.';
    }
    return null;
  }
}

class _Field extends StatelessWidget {
  const _Field({
    required this.controller,
    required this.label,
    this.validator,
    this.keyboardType,
  });

  final TextEditingController controller;
  final String label;
  final String? Function(String?)? validator;
  final TextInputType? keyboardType;

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 16),
      child: TextFormField(
        controller: controller,
        validator: validator,
        keyboardType: keyboardType,
        decoration: InputDecoration(
          labelText: label,
          filled: true,
          fillColor: const Color(0xFFF8FAFC),
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(8),
          ),
        ),
      ),
    );
  }
}

class _SexeDropdown extends StatelessWidget {
  const _SexeDropdown({required this.value, required this.onChanged});

  final String value;
  final ValueChanged<String> onChanged;

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 16),
      child: DropdownButtonFormField<String>(
        initialValue: value,
        decoration: InputDecoration(
          labelText: 'Sexe *',
          filled: true,
          fillColor: const Color(0xFFF8FAFC),
          border: OutlineInputBorder(
            borderRadius: BorderRadius.circular(8),
          ),
        ),
        items: const [
          DropdownMenuItem(value: 'M', child: Text('Masculin')),
          DropdownMenuItem(value: 'F', child: Text('Feminin')),
        ],
        onChanged: (v) => onChanged(v ?? 'M'),
      ),
    );
  }
}

class _Pair extends StatelessWidget {
  const _Pair({
    required this.isWide,
    required this.first,
    required this.second,
  });

  final bool isWide;
  final Widget first;
  final Widget second;

  @override
  Widget build(BuildContext context) {
    if (isWide) {
      return Row(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Expanded(child: first),
          const SizedBox(width: 16),
          Expanded(child: second),
        ],
      );
    }
    return Column(children: [first, second]);
  }
}
