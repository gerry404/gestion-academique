import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:provider/provider.dart';

import '../../models/note.dart';
import '../../providers/note_provider.dart';

class NotesPage extends StatefulWidget {
  const NotesPage({super.key});

  @override
  State<NotesPage> createState() => _NotesPageState();
}

class _NotesPageState extends State<NotesPage> {
  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      context.read<NoteProvider>().load();
    });
  }

  Future<void> _confirmDelete(Note note) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Supprimer'),
        content: const Text('Supprimer cette note ?'),
        actions: [
          TextButton(
            onPressed: () => Navigator.of(context).pop(false),
            child: const Text('Annuler'),
          ),
          FilledButton(
            style: FilledButton.styleFrom(
              backgroundColor: const Color(0xFFB91C1C),
            ),
            onPressed: () => Navigator.of(context).pop(true),
            child: const Text('Supprimer'),
          ),
        ],
      ),
    );

    if (confirm == true && note.id != null && mounted) {
      final ok = await context.read<NoteProvider>().delete(note.id!);
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(ok ? 'Note supprimee.' : 'Suppression impossible.'),
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    final provider = context.watch<NoteProvider>();
    final isWide = MediaQuery.sizeOf(context).width >= 800;

    return SingleChildScrollView(
      padding: const EdgeInsets.all(24),
      child: Center(
        child: ConstrainedBox(
          constraints: const BoxConstraints(maxWidth: 1100),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              _Header(isWide: isWide),
              const SizedBox(height: 16),
              if (provider.isLoading)
                const Padding(
                  padding: EdgeInsets.symmetric(vertical: 48),
                  child: Center(child: CircularProgressIndicator()),
                )
              else if (provider.error != null)
                _Message(text: provider.error!, color: const Color(0xFFB91C1C))
              else if (provider.notes.isEmpty)
                const _Message(
                  text: 'Aucune note pour le moment.',
                  color: Color(0xFF64748B),
                )
              else if (isWide)
                _NotesTable(
                  notes: provider.notes,
                  onEdit: (n) => context.push('/notes/form', extra: n),
                  onDelete: _confirmDelete,
                )
              else
                Column(
                  children: [
                    for (final n in provider.notes)
                      _NoteCard(
                        note: n,
                        onEdit: () => context.push('/notes/form', extra: n),
                        onDelete: () => _confirmDelete(n),
                      ),
                  ],
                ),
            ],
          ),
        ),
      ),
    );
  }
}

class _Header extends StatelessWidget {
  const _Header({required this.isWide});

  final bool isWide;

  @override
  Widget build(BuildContext context) {
    final title = Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: const [
        Text(
          'Gestion des notes',
          style: TextStyle(
            fontSize: 24,
            fontWeight: FontWeight.bold,
            color: Color(0xFF1E293B),
          ),
        ),
        SizedBox(height: 4),
        Text(
          'Attribution des notes CC et SN par matiere.',
          style: TextStyle(color: Color(0xFF64748B)),
        ),
      ],
    );

    final button = FilledButton.icon(
      onPressed: () => context.push('/notes/form'),
      icon: const Icon(Icons.add, size: 18),
      label: const Text('Ajouter'),
    );

    if (isWide) {
      return Row(children: [Expanded(child: title), button]);
    }
    return Column(
      crossAxisAlignment: CrossAxisAlignment.stretch,
      children: [title, const SizedBox(height: 12), button],
    );
  }
}

class _NotesTable extends StatelessWidget {
  const _NotesTable({
    required this.notes,
    required this.onEdit,
    required this.onDelete,
  });

  final List<Note> notes;
  final ValueChanged<Note> onEdit;
  final ValueChanged<Note> onDelete;

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: const Color(0xFFE2E8F0)),
      ),
      child: SizedBox(
        width: double.infinity,
        child: SingleChildScrollView(
          scrollDirection: Axis.horizontal,
          child: DataTable(
            headingTextStyle: const TextStyle(
              fontWeight: FontWeight.w600,
              color: Color(0xFF475569),
            ),
            columns: const [
              DataColumn(label: Text('Etudiant')),
              DataColumn(label: Text('Matiere')),
              DataColumn(label: Text('Type')),
              DataColumn(label: Text('Note')),
              DataColumn(label: Text('Actions')),
            ],
            rows: [
              for (final n in notes)
                DataRow(
                  cells: [
                    DataCell(Text(n.etudiant?.nomComplet ?? '#${n.etudiantId}')),
                    DataCell(Text(n.matiere?.libelle ?? '#${n.matiereId}')),
                    DataCell(Text(n.type)),
                    DataCell(Text(n.valeur.toStringAsFixed(2))),
                    DataCell(
                      Row(
                        children: [
                          IconButton(
                            tooltip: 'Modifier',
                            icon: const Icon(Icons.edit, size: 18),
                            color: const Color(0xFF1D4ED8),
                            onPressed: () => onEdit(n),
                          ),
                          IconButton(
                            tooltip: 'Supprimer',
                            icon: const Icon(Icons.delete, size: 18),
                            color: const Color(0xFFB91C1C),
                            onPressed: () => onDelete(n),
                          ),
                        ],
                      ),
                    ),
                  ],
                ),
            ],
          ),
        ),
      ),
    );
  }
}

class _NoteCard extends StatelessWidget {
  const _NoteCard({
    required this.note,
    required this.onEdit,
    required this.onDelete,
  });

  final Note note;
  final VoidCallback onEdit;
  final VoidCallback onDelete;

  @override
  Widget build(BuildContext context) {
    return Container(
      margin: const EdgeInsets.only(bottom: 12),
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: const Color(0xFFE2E8F0)),
      ),
      child: Row(
        children: [
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  note.etudiant?.nomComplet ?? '#${note.etudiantId}',
                  style: const TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                    color: Color(0xFF1E293B),
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  '${note.matiere?.libelle ?? '#${note.matiereId}'} - ${note.type} : ${note.valeur.toStringAsFixed(2)}/20',
                  style: const TextStyle(
                    fontSize: 13,
                    color: Color(0xFF64748B),
                  ),
                ),
              ],
            ),
          ),
          IconButton(
            icon: const Icon(Icons.edit, size: 18),
            color: const Color(0xFF1D4ED8),
            onPressed: onEdit,
          ),
          IconButton(
            icon: const Icon(Icons.delete, size: 18),
            color: const Color(0xFFB91C1C),
            onPressed: onDelete,
          ),
        ],
      ),
    );
  }
}

class _Message extends StatelessWidget {
  const _Message({required this.text, required this.color});

  final String text;
  final Color color;

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.symmetric(vertical: 32),
      alignment: Alignment.center,
      child: Text(text, style: TextStyle(color: color)),
    );
  }
}
