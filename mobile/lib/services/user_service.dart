import 'package:dio/dio.dart';

import '../api/api_client.dart';
import '../models/user.dart';

class UserService {
  UserService(this._api);

  final ApiClient _api;

  Future<List<User>> list({String? search, String? role}) async {
    final params = <String, dynamic>{};
    if (search != null && search.isNotEmpty) params['search'] = search;
    if (role != null && role.isNotEmpty) params['role'] = role;

    final response = await _api.dio.get(
      '/api/utilisateurs',
      queryParameters: params.isEmpty ? null : params,
    );
    final data = response.data['data'] as List<dynamic>;
    return data.map((e) => User.fromJson(e as Map<String, dynamic>)).toList();
  }

  Future<User> create({
    required String name,
    required String email,
    required String password,
    required String role,
  }) async {
    final response = await _api.dio.post('/api/utilisateurs', data: {
      'name': name,
      'email': email,
      'password': password,
      'role': role,
    });
    return User.fromJson(response.data['data'] as Map<String, dynamic>);
  }

  Future<User> update(
    int id, {
    required String name,
    required String email,
    String? password,
    required String role,
  }) async {
    final response = await _api.dio.put('/api/utilisateurs/$id', data: {
      'name': name,
      'email': email,
      if (password != null && password.isNotEmpty) 'password': password,
      'role': role,
    });
    return User.fromJson(response.data['data'] as Map<String, dynamic>);
  }

  Future<void> delete(int id) async {
    await _api.dio.delete('/api/utilisateurs/$id');
  }

  static String messageFromError(Object error) {
    if (error is DioException) {
      final data = error.response?.data;
      if (data is Map) {
        if (data['errors'] is Map) {
          final errors = data['errors'] as Map;
          final first = errors.values.first;
          if (first is List && first.isNotEmpty) {
            return first.first.toString();
          }
        }
        if (data['message'] is String) {
          return data['message'] as String;
        }
      }
      if (error.response == null) {
        return 'Impossible de joindre le serveur.';
      }
    }
    return 'Une erreur est survenue.';
  }
}
