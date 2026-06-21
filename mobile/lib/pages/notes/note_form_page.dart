import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:provider/provider.dart';

import '../../models/note.dart';
import '../../providers/etudiant_provider.dart';
import '../../providers/matiere_provider.dart';
import '../../providers/note_provider.dart';

class NoteFormPage extends StatefulWidget {
  const NoteFormPage({super.key, this.note});

  final Note? note;

  @override
  State<NoteFormPage> createState() => _NoteFormPageState();
}

class _NoteFormPageState extends State<NoteFormPage> {
  final _formKey = GlobalKey<FormState>();
  late final TextEditingController _valeur;
  int? _etudiantId;
  int? _matiereId;
  String _type = 'CC';
  bool _submitting = false;

  bool get _isEdit => widget.note != null;

  @override
  void initState() {
    super.initState();
    _valeur = TextEditingController(text: widget.note?.valeur.toString() ?? '');
    _etudiantId = widget.note?.etudiantId;
    _matiereId = widget.note?.matiereId;
    _type = widget.note?.type ?? 'CC';
    WidgetsBinding.instance.addPostFrameCallback((_) {
      context.read<EtudiantProvider>().load();
      context.read<MatiereProvider>().load();
    });
  }

  @override
  void dispose() {
    _valeur.dispose();
    super.dispose();
  }

  Future<void> _submit() async {
    if (!_formKey.currentState!.validate()) return;
    if (_etudiantId == null || _matiereId == null) {
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(
          content: Text('Selectionnez un etudiant et une matiere.'),
        ),
      );
      return;
    }

    setState(() => _submitting = true);

    final note = Note(
      id: widget.note?.id,
      etudiantId: _etudiantId!,
      matiereId: _matiereId!,
      type: _type,
      valeur: double.tryParse(_valeur.text.trim().replaceAll(',', '.')) ?? 0,
    );

    final provider = context.read<NoteProvider>();
    final ok = _isEdit
        ? await provider.update(widget.note!.id!, note)
        : await provider.create(note);

    if (!mounted) return;
    setState(() => _submitting = false);

    if (ok) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(_isEdit ? 'Note modifiee.' : 'Note ajoutee.')),
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
    final etudiants = context.watch<EtudiantProvider>().etudiants;
    final matieres = context.watch<MatiereProvider>().matieres;

    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        backgroundColor: Colors.white,
        foregroundColor: const Color(0xFF1E293B),
        elevation: 0,
        shape: const Border(bottom: BorderSide(color: Color(0xFFE2E8F0))),
        title: Text(_isEdit ? 'Modifier une note' : 'Nouvelle note'),
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
                    _Label('Etudiant *'),
                    DropdownButtonFormField<int>(
                      initialValue: _etudiantId,
                      isExpanded: true,
                      decoration: _decoration(),
                      hint: const Text('Selectionner un etudiant'),
                      items: [
                        for (final e in etudiants)
                          if (e.id != null)
                            DropdownMenuItem(
                              value: e.id,
                              child: Text('${e.nomComplet} (${e.matricule})'),
                            ),
                      ],
                      onChanged: (v) => setState(() => _etudiantId = v),
                    ),
                    const SizedBox(height: 16),
                    _Label('Matiere *'),
                    DropdownButtonFormField<int>(
                      initialValue: _matiereId,
                      isExpanded: true,
                      decoration: _decoration(),
                      hint: const Text('Selectionner une matiere'),
                      items: [
                        for (final m in matieres)
                          if (m.id != null)
                            DropdownMenuItem(
                              value: m.id,
                              child: Text('${m.libelle} (${m.code})'),
                            ),
                      ],
                      onChanged: (v) => setState(() => _matiereId = v),
                    ),
                    const SizedBox(height: 16),
                    _Label('Type *'),
                    DropdownButtonFormField<String>(
                      initialValue: _type,
                      decoration: _decoration(),
                      items: const [
                        DropdownMenuItem(
                          value: 'CC',
                          child: Text('CC (controle continu)'),
                        ),
                        DropdownMenuItem(
                          value: 'SN',
                          child: Text('SN (session normale)'),
                        ),
                      ],
                      onChanged: (v) => setState(() => _type = v ?? 'CC'),
                    ),
                    const SizedBox(height: 16),
                    _Label('Note (sur 20) *'),
                    TextFormField(
                      controller: _valeur,
                      keyboardType: const TextInputType.numberWithOptions(
                        decimal: true,
                      ),
                      decoration: _decoration(),
                      validator: (v) {
                        final n = double.tryParse(
                          (v ?? '').trim().replaceAll(',', '.'),
                        );
                        if (n == null) return 'Note invalide.';
                        if (n < 0 || n > 20) return 'Entre 0 et 20.';
                        return null;
                      },
                    ),
                    const SizedBox(height: 24),
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

  InputDecoration _decoration() {
    return InputDecoration(
      filled: true,
      fillColor: const Color(0xFFF8FAFC),
      border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
    );
  }
}

class _Label extends StatelessWidget {
  const _Label(this.text);

  final String text;

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 6),
      child: Text(
        text,
        style: const TextStyle(
          fontSize: 14,
          fontWeight: FontWeight.w500,
          color: Color(0xFF334155),
        ),
      ),
    );
  }
}
