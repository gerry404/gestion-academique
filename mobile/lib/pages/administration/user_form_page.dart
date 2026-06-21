import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:provider/provider.dart';

import '../../models/user.dart';
import '../../providers/user_provider.dart';

class UserFormPage extends StatefulWidget {
  const UserFormPage({super.key, this.user});

  final User? user;

  @override
  State<UserFormPage> createState() => _UserFormPageState();
}

class _UserFormPageState extends State<UserFormPage> {
  final _formKey = GlobalKey<FormState>();
  late final TextEditingController _name;
  late final TextEditingController _email;
  late final TextEditingController _password;
  UserRole _role = UserRole.responsable;
  bool _submitting = false;

  bool get _isEdit => widget.user != null;

  @override
  void initState() {
    super.initState();
    _name = TextEditingController(text: widget.user?.name ?? '');
    _email = TextEditingController(text: widget.user?.email ?? '');
    _password = TextEditingController();
    _role = widget.user?.role ?? UserRole.responsable;
  }

  @override
  void dispose() {
    _name.dispose();
    _email.dispose();
    _password.dispose();
    super.dispose();
  }

  Future<void> _submit() async {
    if (!_formKey.currentState!.validate()) return;

    setState(() => _submitting = true);
    final provider = context.read<UserProvider>();

    final ok = _isEdit
        ? await provider.update(
            widget.user!.id,
            name: _name.text.trim(),
            email: _email.text.trim(),
            password: _password.text,
            role: _role.name,
          )
        : await provider.create(
            name: _name.text.trim(),
            email: _email.text.trim(),
            password: _password.text,
            role: _role.name,
          );

    if (!mounted) return;
    setState(() => _submitting = false);

    if (ok) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(_isEdit ? 'Utilisateur modifie.' : 'Utilisateur cree.'),
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
    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        backgroundColor: Colors.white,
        foregroundColor: const Color(0xFF1E293B),
        elevation: 0,
        shape: const Border(bottom: BorderSide(color: Color(0xFFE2E8F0))),
        title: Text(_isEdit ? 'Modifier un utilisateur' : 'Nouvel utilisateur'),
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
                      controller: _name,
                      label: 'Nom *',
                      validator: _required,
                    ),
                    _Field(
                      controller: _email,
                      label: 'Email *',
                      keyboardType: TextInputType.emailAddress,
                      validator: (v) {
                        if (v == null || v.trim().isEmpty) {
                          return 'Champ obligatoire.';
                        }
                        if (!v.contains('@')) {
                          return 'Email invalide.';
                        }
                        return null;
                      },
                    ),
                    _Field(
                      controller: _password,
                      label: _isEdit
                          ? 'Mot de passe (laisser vide pour ne pas changer)'
                          : 'Mot de passe *',
                      obscureText: true,
                      validator: (v) {
                        if (!_isEdit && (v == null || v.isEmpty)) {
                          return 'Champ obligatoire.';
                        }
                        if (v != null && v.isNotEmpty && v.length < 6) {
                          return 'Au moins 6 caracteres.';
                        }
                        return null;
                      },
                    ),
                    Padding(
                      padding: const EdgeInsets.only(bottom: 16),
                      child: DropdownButtonFormField<UserRole>(
                        initialValue: _role,
                        decoration: InputDecoration(
                          labelText: 'Role *',
                          filled: true,
                          fillColor: const Color(0xFFF8FAFC),
                          border: OutlineInputBorder(
                            borderRadius: BorderRadius.circular(8),
                          ),
                        ),
                        items: const [
                          DropdownMenuItem(
                            value: UserRole.admin,
                            child: Text('Admin'),
                          ),
                          DropdownMenuItem(
                            value: UserRole.responsable,
                            child: Text('Responsable'),
                          ),
                          DropdownMenuItem(
                            value: UserRole.enseignant,
                            child: Text('Enseignant'),
                          ),
                        ],
                        onChanged: (v) => setState(
                          () => _role = v ?? UserRole.responsable,
                        ),
                      ),
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
                              : Text(_isEdit ? 'Enregistrer' : 'Creer'),
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
    this.obscureText = false,
  });

  final TextEditingController controller;
  final String label;
  final String? Function(String?)? validator;
  final TextInputType? keyboardType;
  final bool obscureText;

  @override
  Widget build(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 16),
      child: TextFormField(
        controller: controller,
        validator: validator,
        keyboardType: keyboardType,
        obscureText: obscureText,
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
