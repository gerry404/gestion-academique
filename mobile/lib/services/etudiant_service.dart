import 'package:dio/dio.dart';

import '../api/api_client.dart';
import '../models/etudiant.dart';

class EtudiantService {
  EtudiantService(this._api);

  final ApiClient _api;

  Future<List<Etudiant>> list({String? search}) async {
    final response = await _api.dio.get(
      '/api/etudiants',
      queryParameters: search != null && search.isNotEmpty
          ? {'search': search}
          : null,
    );
    final data = response.data['data'] as List<dynamic>;
    return data
        .map((e) => Etudiant.fromJson(e as Map<String, dynamic>))
        .toList();
  }

  Future<Etudiant> create(Etudiant etudiant) async {
    final response =
        await _api.dio.post('/api/etudiants', data: etudiant.toJson());
    return Etudiant.fromJson(response.data['data'] as Map<String, dynamic>);
  }

  Future<Etudiant> update(int id, Etudiant etudiant) async {
    final response =
        await _api.dio.put('/api/etudiants/$id', data: etudiant.toJson());
    return Etudiant.fromJson(response.data['data'] as Map<String, dynamic>);
  }

  Future<void> delete(int id) async {
    await _api.dio.delete('/api/etudiants/$id');
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
    }
    return 'Une erreur est survenue.';
  }
}
