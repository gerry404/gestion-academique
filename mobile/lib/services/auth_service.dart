import 'package:dio/dio.dart';

import '../api/api_client.dart';
import '../models/login_credentials.dart';
import '../models/user.dart';
import 'token_storage.dart';

class AuthService {
  AuthService(this._api, this._tokenStorage);

  final ApiClient _api;
  final TokenStorage _tokenStorage;

  Future<User> login(LoginCredentials credentials) async {
    final response =
        await _api.dio.post('/api/login', data: credentials.toJson());
    final data = response.data as Map<String, dynamic>;
    await _tokenStorage.write(data['token'] as String);
    return User.fromJson(data['user'] as Map<String, dynamic>);
  }

  Future<void> logout() async {
    try {
      await _api.dio.post('/api/logout');
    } on DioException catch (_) {
      await _tokenStorage.clear();
      return;
    }
    await _tokenStorage.clear();
  }

  Future<User?> me() async {
    final token = await _tokenStorage.read();
    if (token == null) {
      return null;
    }
    try {
      final response = await _api.dio.get('/api/me');
      return User.fromJson(response.data['user'] as Map<String, dynamic>);
    } on DioException {
      await _tokenStorage.clear();
      return null;
    }
  }

  static String messageFromError(Object error) {
    if (error is DioException) {
      final data = error.response?.data;
      if (data is Map && data['message'] is String) {
        return data['message'] as String;
      }
    }
    return 'Identifiants incorrects.';
  }
}
