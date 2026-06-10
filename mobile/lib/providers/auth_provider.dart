import 'package:flutter/foundation.dart';

import '../models/login_credentials.dart';
import '../models/user.dart';
import '../services/auth_service.dart';

class AuthProvider extends ChangeNotifier {
  AuthProvider(this._authService) {
    _bootstrap();
  }

  final AuthService _authService;

  User? _user;
  bool _isLoading = true;

  User? get user => _user;
  bool get isLoading => _isLoading;
  bool get isAuthenticated => _user != null;

  Future<void> _bootstrap() async {
    _user = await _authService.me();
    _isLoading = false;
    notifyListeners();
  }

  Future<void> login(LoginCredentials credentials) async {
    _user = await _authService.login(credentials);
    notifyListeners();
  }

  Future<void> logout() async {
    await _authService.logout();
    _user = null;
    notifyListeners();
  }
}
