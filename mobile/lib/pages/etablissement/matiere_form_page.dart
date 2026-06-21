import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:provider/provider.dart';

import '../../models/matiere.dart';
import '../../providers/matiere_provider.dart';

class MatiereFormPage extends StatefulWidget {
  const MatiereFormPage({super.key, this.matiere});

  final Matiere? matiere;

  @override
  State<MatiereFormPage> createState() => _MatiereFormPageState();
}

class _MatiereFormPageState extends State<MatiereFormPage> {
  final _formKey = GlobalKey<FormState>();
  late final TextEditingController _code;
  late final TextEditingController _libelle;
  late final TextEditingController _coefficient;
  bool _submitting = false;

  bool get _isEdit => widget.matiere != null;

  @override
  void initState() {
    super.initState();
    _code = TextEditingController(text: widget.matiere?.code ?? '');
    _libelle = TextEditingController(text: widget.matiere?.libelle ?? '');
    _coefficient = TextEditingController(
      text: widget.matiere?.coefficient.toString() ?? '1',
    );
  }

  @override
  void dispose() {
    _code.dispose();
    _libelle.dispose();
    _coefficient.dispose();
    super.dispose();
  }

  Future<void> _submit() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => _submitting = true);

    final matiere = Matiere(
      id: widget.matiere?.id,
      code: _code.text.trim(),
      libelle: _libelle.text.trim(),
      coefficient: int.tryParse(_coefficient.text.trim()) ?? 1,
    );

    final provider = context.read<MatiereProvider>();
    final ok = _isEdit
        ? await provider.update(widget.matiere!.id!, matiere)
        : await provider.create(matiere);

    if (!mounted) return;
    setState(() => _submitting = false);

    if (ok) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(_isEdit ? 'Matiere modifiee.' : 'Matiere ajoutee.')),
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
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        backgroundColor: Colors.white,
        foregroundColor: const Color(0xFF1E293B),
        elevation: 0,
        shape: const Border(bottom: BorderSide(color: Color(0xFFE2E8F0))),
        title: Text(_isEdit ? 'Modifier une matiere' : 'Nouvelle matiere'),
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(24),
        child: Center(
          child: ConstrainedBox(
            constraints: const BoxConstraints(maxWidth: 600),
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
                      controller: _code,
                      label: 'Code *',
                      validator: _required,
                    ),
                    _Field(
                      controller: _libelle,
                      label: 'Libelle *',
                      validator: _required,
                    ),
                    _Field(
                      controller: _coefficient,
                      label: 'Coefficient *',
                      keyboardType: TextInputType.number,
                      validator: (v) {
                        final n = int.tryParse((v ?? '').trim());
                        if (n == null || n < 1) {
                          return 'Coefficient invalide.';
                        }
                        return null;
                      },
                    ),
                    const SizedBox(height: 8),
                    Row(
                      mainAxisAlignment: MainAxisAlignment.end,
                      children: [
                        TextButton(
                          onPressed: _submitting ? null : () => context.pop(),
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
