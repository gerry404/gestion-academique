import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:provider/provider.dart';

import '../../models/etudiant.dart';
import '../../providers/etudiant_provider.dart';

class EtudiantsPage extends StatefulWidget {
  const EtudiantsPage({super.key});

  @override
  State<EtudiantsPage> createState() => _EtudiantsPageState();
}

class _EtudiantsPageState extends State<EtudiantsPage> {
  final _searchController = TextEditingController();

  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      context.read<EtudiantProvider>().load();
    });
  }

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  Future<void> _confirmDelete(Etudiant etudiant) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Supprimer'),
        content: Text(
          'Voulez-vous vraiment supprimer ${etudiant.nomComplet} ?',
        ),
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

    if (confirm == true && etudiant.id != null && mounted) {
      final ok = await context.read<EtudiantProvider>().delete(etudiant.id!);
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(ok ? 'Etudiant supprime.' : 'Suppression impossible.'),
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    final provider = context.watch<EtudiantProvider>();
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
              _SearchBar(
                controller: _searchController,
                onChanged: (value) =>
                    context.read<EtudiantProvider>().load(search: value),
              ),
              const SizedBox(height: 16),
              if (provider.isLoading)
                const Padding(
                  padding: EdgeInsets.symmetric(vertical: 48),
                  child: Center(child: CircularProgressIndicator()),
                )
              else if (provider.error != null)
                _Message(
                  text: provider.error!,
                  color: const Color(0xFFB91C1C),
                )
              else if (provider.etudiants.isEmpty)
                const _Message(
                  text: 'Aucun etudiant pour le moment.',
                  color: Color(0xFF64748B),
                )
              else if (isWide)
                _EtudiantsTable(
                  etudiants: provider.etudiants,
                  onEdit: (e) => context.push('/etudiants/form', extra: e),
                  onDelete: _confirmDelete,
                )
              else
                Column(
                  children: [
                    for (final e in provider.etudiants)
                      _EtudiantCard(
                        etudiant: e,
                        onEdit: () =>
                            context.push('/etudiants/form', extra: e),
                        onDelete: () => _confirmDelete(e),
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
          'Gestion des etudiants',
          style: TextStyle(
            fontSize: 24,
            fontWeight: FontWeight.bold,
            color: Color(0xFF1E293B),
          ),
        ),
        SizedBox(height: 4),
        Text(
          'Liste, inscription et infos des etudiants.',
          style: TextStyle(color: Color(0xFF64748B)),
        ),
      ],
    );

    final button = FilledButton.icon(
      onPressed: () => context.push('/etudiants/form'),
      icon: const Icon(Icons.add, size: 18),
      label: const Text('Ajouter'),
    );

    if (isWide) {
      return Row(
        children: [
          Expanded(child: title),
          button,
        ],
      );
    }

    return Column(
      crossAxisAlignment: CrossAxisAlignment.stretch,
      children: [
        title,
        const SizedBox(height: 12),
        button,
      ],
    );
  }
}

class _SearchBar extends StatelessWidget {
  const _SearchBar({required this.controller, required this.onChanged});

  final TextEditingController controller;
  final ValueChanged<String> onChanged;

  @override
  Widget build(BuildContext context) {
    return TextField(
      controller: controller,
      onChanged: onChanged,
      decoration: InputDecoration(
        hintText: 'Rechercher (matricule, nom, prenom)',
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
    );
  }
}

class _EtudiantsTable extends StatelessWidget {
  const _EtudiantsTable({
    required this.etudiants,
    required this.onEdit,
    required this.onDelete,
  });

  final List<Etudiant> etudiants;
  final ValueChanged<Etudiant> onEdit;
  final ValueChanged<Etudiant> onDelete;

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
              DataColumn(label: Text('Matricule')),
              DataColumn(label: Text('Nom')),
              DataColumn(label: Text('Prenom')),
              DataColumn(label: Text('Sexe')),
              DataColumn(label: Text('Telephone')),
              DataColumn(label: Text('Actions')),
            ],
            rows: [
              for (final e in etudiants)
                DataRow(
                  cells: [
                    DataCell(Text(e.matricule)),
                    DataCell(Text(e.nom)),
                    DataCell(Text(e.prenom)),
                    DataCell(Text(e.sexe)),
                    DataCell(Text(e.telephone ?? '-')),
                    DataCell(
                      Row(
                        children: [
                          IconButton(
                            tooltip: 'Modifier',
                            icon: const Icon(Icons.edit, size: 18),
                            color: const Color(0xFF1D4ED8),
                            onPressed: () => onEdit(e),
                          ),
                          IconButton(
                            tooltip: 'Supprimer',
                            icon: const Icon(Icons.delete, size: 18),
                            color: const Color(0xFFB91C1C),
                            onPressed: () => onDelete(e),
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

class _EtudiantCard extends StatelessWidget {
  const _EtudiantCard({
    required this.etudiant,
    required this.onEdit,
    required this.onDelete,
  });

  final Etudiant etudiant;
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
                  etudiant.nomComplet,
                  style: const TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                    color: Color(0xFF1E293B),
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  '${etudiant.matricule} - ${etudiant.sexe}',
                  style: const TextStyle(
                    fontSize: 13,
                    color: Color(0xFF64748B),
                  ),
                ),
                if (etudiant.telephone != null)
                  Text(
                    etudiant.telephone!,
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
