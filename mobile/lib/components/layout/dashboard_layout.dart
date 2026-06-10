import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../../providers/auth_provider.dart';

class DashboardLayout extends StatelessWidget {
  const DashboardLayout({super.key, required this.child});

  final Widget child;

  static const _navItems = <String>[
    'Accueil',
    'Etablissement',
    'Etudiants',
    'Notes',
    'Effets academiques',
    'Statistiques',
    'Administration',
  ];

  @override
  Widget build(BuildContext context) {
    final user = context.watch<AuthProvider>().user;
    final isWide = MediaQuery.sizeOf(context).width >= 800;

    final topbar = _Topbar(
      userName: user?.name ?? '',
      role: user?.role.label ?? '',
      onLogout: () => context.read<AuthProvider>().logout(),
    );

    if (isWide) {
      return Scaffold(
        backgroundColor: const Color(0xFFF8FAFC),
        body: Row(
          children: [
            const _Sidebar(),
            Expanded(
              child: Column(
                children: [
                  topbar,
                  Expanded(child: child),
                ],
              ),
            ),
          ],
        ),
      );
    }

    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        backgroundColor: Colors.white,
        foregroundColor: const Color(0xFF1E293B),
        elevation: 0,
        shape: const Border(
          bottom: BorderSide(color: Color(0xFFE2E8F0)),
        ),
        title: const Text(
          'Gestion Scolaire',
          style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
        ),
        actions: [
          if ((user?.role.label ?? '').isNotEmpty)
            Padding(
              padding: const EdgeInsets.only(right: 8),
              child: Center(child: _RoleChip(role: user!.role.label)),
            ),
          IconButton(
            tooltip: 'Deconnexion',
            icon: const Icon(Icons.logout, color: Color(0xFFB91C1C)),
            onPressed: () => context.read<AuthProvider>().logout(),
          ),
        ],
      ),
      drawer: const Drawer(child: _Sidebar()),
      body: child,
    );
  }
}

class _Sidebar extends StatelessWidget {
  const _Sidebar();

  @override
  Widget build(BuildContext context) {
    return Container(
      width: 256,
      color: Colors.white,
      padding: const EdgeInsets.all(16),
      child: SafeArea(
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.stretch,
          children: [
            const Padding(
              padding: EdgeInsets.symmetric(horizontal: 8),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'Gestion Scolaire',
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: Color(0xFF1E293B),
                    ),
                  ),
                  Text(
                    'Tableau de bord',
                    style: TextStyle(fontSize: 12, color: Color(0xFF64748B)),
                  ),
                ],
              ),
            ),
            const SizedBox(height: 24),
            for (var i = 0; i < DashboardLayout._navItems.length; i++)
              _NavItem(
                label: DashboardLayout._navItems[i],
                active: i == 0,
              ),
          ],
        ),
      ),
    );
  }
}

class _NavItem extends StatelessWidget {
  const _NavItem({required this.label, this.active = false});

  final String label;
  final bool active;

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 4),
      child: Material(
        color: active ? const Color(0xFFEFF6FF) : Colors.transparent,
        borderRadius: BorderRadius.circular(8),
        child: InkWell(
          borderRadius: BorderRadius.circular(8),
          onTap: () {},
          child: Padding(
            padding:
                const EdgeInsets.symmetric(horizontal: 12, vertical: 10),
            child: Text(
              label,
              style: TextStyle(
                fontSize: 14,
                fontWeight: active ? FontWeight.w500 : FontWeight.normal,
                color: active
                    ? const Color(0xFF1D4ED8)
                    : const Color(0xFF475569),
              ),
            ),
          ),
        ),
      ),
    );
  }
}

class _Topbar extends StatelessWidget {
  const _Topbar({
    required this.userName,
    required this.role,
    required this.onLogout,
  });

  final String userName;
  final String role;
  final VoidCallback onLogout;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 12),
      decoration: const BoxDecoration(
        color: Colors.white,
        border: Border(bottom: BorderSide(color: Color(0xFFE2E8F0))),
      ),
      child: Row(
        children: [
          Expanded(
            child: Wrap(
              crossAxisAlignment: WrapCrossAlignment.center,
              spacing: 8,
              children: [
                Text.rich(
                  TextSpan(
                    text: 'Connecte en tant que ',
                    style: const TextStyle(
                      fontSize: 14,
                      color: Color(0xFF64748B),
                    ),
                    children: [
                      TextSpan(
                        text: userName,
                        style: const TextStyle(
                          fontWeight: FontWeight.w500,
                          color: Color(0xFF1E293B),
                        ),
                      ),
                    ],
                  ),
                ),
                if (role.isNotEmpty) _RoleChip(role: role),
              ],
            ),
          ),
          TextButton.icon(
            onPressed: onLogout,
            style: TextButton.styleFrom(
              backgroundColor: const Color(0xFFFEF2F2),
              foregroundColor: const Color(0xFFB91C1C),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(8),
              ),
            ),
            icon: const Icon(Icons.logout, size: 16),
            label: const Text('Deconnexion'),
          ),
        ],
      ),
    );
  }
}

class _RoleChip extends StatelessWidget {
  const _RoleChip({required this.role});

  final String role;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
      decoration: BoxDecoration(
        color: const Color(0xFFDBEAFE),
        borderRadius: BorderRadius.circular(999),
      ),
      child: Text(
        role,
        style: const TextStyle(
          fontSize: 12,
          fontWeight: FontWeight.w500,
          color: Color(0xFF1D4ED8),
        ),
      ),
    );
  }
}
