import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:provider/provider.dart';

import '../../models/user.dart';
import '../../providers/auth_provider.dart';
import '../../providers/user_provider.dart';

class AdministrationPage extends StatefulWidget {
  const AdministrationPage({super.key});

  @override
  State<AdministrationPage> createState() => _AdministrationPageState();
}

class _AdministrationPageState extends State<AdministrationPage> {
  final _searchController = TextEditingController();

  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      context.read<UserProvider>().load();
    });
  }

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  Future<void> _confirmDelete(User user) async {
    final confirm = await showDialog<bool>(
      context: context,
      builder: (context) => AlertDialog(
        title: const Text('Supprimer'),
        content: Text('Supprimer le compte de ${user.name} ?'),
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

    if (confirm == true && mounted) {
      final provider = context.read<UserProvider>();
      final ok = await provider.delete(user.id);
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(
            ok ? 'Utilisateur supprime.' : (provider.error ?? 'Erreur.'),
          ),
        ),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    final provider = context.watch<UserProvider>();
    final currentId = context.watch<AuthProvider>().user?.id;
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
                    context.read<UserProvider>().load(search: value),
                decoration: InputDecoration(
                  hintText: 'Rechercher (nom, email)',
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
              else if (provider.users.isEmpty)
                const _Message(
                  text: 'Aucun utilisateur.',
                  color: Color(0xFF64748B),
                )
              else if (isWide)
                _UsersTable(
                  users: provider.users,
                  currentId: currentId,
                  onEdit: (u) => context.push('/administration/form', extra: u),
                  onDelete: _confirmDelete,
                )
              else
                Column(
                  children: [
                    for (final u in provider.users)
                      _UserCard(
                        user: u,
                        canDelete: u.id != currentId,
                        onEdit: () =>
                            context.push('/administration/form', extra: u),
                        onDelete: () => _confirmDelete(u),
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
          'Administration',
          style: TextStyle(
            fontSize: 24,
            fontWeight: FontWeight.bold,
            color: Color(0xFF1E293B),
          ),
        ),
        SizedBox(height: 4),
        Text(
          'Utilisateurs, roles et permissions.',
          style: TextStyle(color: Color(0xFF64748B)),
        ),
      ],
    );

    final button = FilledButton.icon(
      onPressed: () => context.push('/administration/form'),
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

class _UsersTable extends StatelessWidget {
  const _UsersTable({
    required this.users,
    required this.currentId,
    required this.onEdit,
    required this.onDelete,
  });

  final List<User> users;
  final int? currentId;
  final ValueChanged<User> onEdit;
  final ValueChanged<User> onDelete;

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
              DataColumn(label: Text('Nom')),
              DataColumn(label: Text('Email')),
              DataColumn(label: Text('Role')),
              DataColumn(label: Text('Actions')),
            ],
            rows: [
              for (final u in users)
                DataRow(
                  cells: [
                    DataCell(Text(u.name)),
                    DataCell(Text(u.email)),
                    DataCell(_RoleChip(role: u.role)),
                    DataCell(
                      Row(
                        children: [
                          IconButton(
                            tooltip: 'Modifier',
                            icon: const Icon(Icons.edit, size: 18),
                            color: const Color(0xFF1D4ED8),
                            onPressed: () => onEdit(u),
                          ),
                          IconButton(
                            tooltip: u.id == currentId
                                ? 'Compte courant'
                                : 'Supprimer',
                            icon: const Icon(Icons.delete, size: 18),
                            color: const Color(0xFFB91C1C),
                            onPressed:
                                u.id == currentId ? null : () => onDelete(u),
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

class _UserCard extends StatelessWidget {
  const _UserCard({
    required this.user,
    required this.canDelete,
    required this.onEdit,
    required this.onDelete,
  });

  final User user;
  final bool canDelete;
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
                  user.name,
                  style: const TextStyle(
                    fontSize: 16,
                    fontWeight: FontWeight.w600,
                    color: Color(0xFF1E293B),
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  user.email,
                  style: const TextStyle(
                    fontSize: 13,
                    color: Color(0xFF64748B),
                  ),
                ),
                const SizedBox(height: 6),
                _RoleChip(role: user.role),
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
            onPressed: canDelete ? onDelete : null,
          ),
        ],
      ),
    );
  }
}

class _RoleChip extends StatelessWidget {
  const _RoleChip({required this.role});

  final UserRole role;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
      decoration: BoxDecoration(
        color: const Color(0xFFDBEAFE),
        borderRadius: BorderRadius.circular(999),
      ),
      child: Text(
        role.label,
        style: const TextStyle(
          fontSize: 12,
          fontWeight: FontWeight.w500,
          color: Color(0xFF1D4ED8),
        ),
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
