import 'package:flutter/foundation.dart';

import '../models/user.dart';
import '../services/user_service.dart';

class UserProvider extends ChangeNotifier {
  UserProvider(this._service);

  final UserService _service;

  List<User> _users = [];
  bool _isLoading = false;
  String? _error;
  String _search = '';

  List<User> get users => _users;
  bool get isLoading => _isLoading;
  String? get error => _error;

  Future<void> load({String? search}) async {
    if (search != null) {
      _search = search;
    }
    _isLoading = true;
    _error = null;
    notifyListeners();
    try {
      _users = await _service.list(search: _search);
    } catch (e) {
      _error = UserService.messageFromError(e);
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<bool> create({
    required String name,
    required String email,
    required String password,
    required String role,
  }) async {
    try {
      final created = await _service.create(
        name: name,
        email: email,
        password: password,
        role: role,
      );
      _users = [..._users, created]..sort((a, b) => a.name.compareTo(b.name));
      notifyListeners();
      return true;
    } catch (e) {
      _error = UserService.messageFromError(e);
      notifyListeners();
      return false;
    }
  }

  Future<bool> update(
    int id, {
    required String name,
    required String email,
    String? password,
    required String role,
  }) async {
    try {
      final updated = await _service.update(
        id,
        name: name,
        email: email,
        password: password,
        role: role,
      );
      _users = [
        for (final u in _users) u.id == id ? updated : u,
      ];
      notifyListeners();
      return true;
    } catch (e) {
      _error = UserService.messageFromError(e);
      notifyListeners();
      return false;
    }
  }

  Future<bool> delete(int id) async {
    try {
      await _service.delete(id);
      _users = _users.where((u) => u.id != id).toList();
      notifyListeners();
      return true;
    } catch (e) {
      _error = UserService.messageFromError(e);
      notifyListeners();
      return false;
    }
  }
}
