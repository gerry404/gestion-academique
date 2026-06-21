import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:provider/provider.dart';

import '../../models/matiere.dart';
import '../../providers/matiere_provider.dart';

class EtablissementPage extends StatefulWidget {
  const EtablissementPage({super.key});

  @override
  State<EtablissementPage> createState() => _EtablissementPageState();
}

class _EtablissementPageState extends State<EtablissementPage> {
  final _searchController = TextEditingController();

  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      context.read<MatiereProvider>().load();
    });
  }

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  Future<void> _confirmDelete(Matiere matiere) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Supprimer'),
        content: Text('Supprimer la matiere ${matiere.libelle} ?'),
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

    if (confirm == true && matiere.id != null && mounted) {
      final ok = await context.read<MatiereProvider>().delete(matiere.id!);
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(ok ? 'Matiere supprimee.' : 'Suppression impossible.'),
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    final provider = context.watch<MatiereProvider>();
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
              TextField(
                controller: _searchController,
                onChanged: (value) =>
                    context.read<MatiereProvider>().load(search: value),
                decoration: InputDecoration(
                  hintText: 'Rechercher (code, libelle)',
                  prefixIcon: const Icon(Icons.search),
                  filled: true,
                  fillColor: Colors.white,
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(8),
                    borderSide: const BorderSide(color: Color(0xFFE2E8F0)),
                  ),
                  enabledBorder: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(8),
                    borderSide: const BorderSide(color: Color(0xFFE2E8F0)),
                  ),
                ),
              ),
              const SizedBox(height: 16),
              if (provider.isLoading)
                const Padding(
                  padding: EdgeInsets.symmetric(vertical: 48),
                  child: Center(child: CircularProgressIndicator()),
                )
              else if (provider.error != null)
                _Message(text: provider.error!, color: const Color(0xFFB91C1C))
              else if (provider.matieres.isEmpty)
                const _Message(
                  text: 'Aucune matiere pour le moment.',
                  color: Color(0xFF64748B),
                )
              else if (isWide)
                _MatieresTable(
                  matieres: provider.matieres,
                  onEdit: (m) => context.push('/etablissement/form', extra: m),
                  onDelete: _confirmDelete,
                )
              else
                Column(
                  children: [
                    for (final m in provider.matieres)
                      _MatiereCard(
                        matiere: m,
                        onEdit: () =>
                            context.push('/etablissement/form', extra: m),
                        onDelete: () => _confirmDelete(m),
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
          "Gestion de l'etablissement",
          style: TextStyle(
            fontSize: 24,
            fontWeight: FontWeight.bold,
            color: Color(0xFF1E293B),
          ),
        ),
        SizedBox(height: 4),
        Text(
          'Matieres et coefficients.',
          style: TextStyle(color: Color(0xFF64748B)),
        ),
      ],
    );

    final button = FilledButton.icon(
      onPressed: () => context.push('/etablissement/form'),
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

class _MatieresTable extends StatelessWidget {
  const _MatieresTable({
    required this.matieres,
    required this.onEdit,
    required this.onDelete,
  });

  final List<Matiere> matieres;
  final ValueChanged<Matiere> onEdit;
  final ValueChanged<Matiere> onDelete;

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
              DataColumn(label: Text('Code')),
              DataColumn(label: Text('Libelle')),
              DataColumn(label: Text('Coefficient')),
              DataColumn(label: Text('Actions')),
            ],
            rows: [
              for (final m in matieres)
                DataRow(
                  cells: [
                    DataCell(Text(m.code)),
                    DataCell(Text(m.libelle)),
                    DataCell(Text('${m.coefficient}')),
                    DataCell(
                      Row(
                        children: [
                          IconButton(
                            tooltip: 'Modifier',
                            icon: const Icon(Icons.edit, size: 18),
                            color: const Color(0xFF1D4ED8),
                            onPressed: () => onEdit(m),
                          ),
                          IconButton(
                            tooltip: 'Supprimer',
                            icon: const Icon(Icons.delete, size: 18),
                            color: const Color(0xFFB91C1C),
                            onPressed: () => onDelete(m),
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

class _MatiereCard extends StatelessWidget {
  const _MatiereCard({
    required this.matiere,
    required this.onEdit,
    required this.onDelete,
  });

  final Matiere matiere;
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
                  matiere.libelle,
                  style: const TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                    color: Color(0xFF1E293B),
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  '${matiere.code} - coef ${matiere.coefficient}',
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
