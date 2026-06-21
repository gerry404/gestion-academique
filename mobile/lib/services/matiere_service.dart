import 'package:dio/dio.dart';

import '../api/api_client.dart';
import '../models/matiere.dart';

class MatiereService {
  MatiereService(this._api);

  final ApiClient _api;

  Future<List<Matiere>> list({String? search}) async {
    final response = await _api.dio.get(
      '/api/matieres',
      queryParameters: search != null && search.isNotEmpty
          ? {'search': search}
          : null,
    );
    final data = response.data['data'] as List<dynamic>;
    return data
        .map((e) => Matiere.fromJson(e as Map<String, dynamic>))
        .toList();
  }

  Future<Matiere> create(Matiere matiere) async {
    final response =
        await _api.dio.post('/api/matieres', data: matiere.toJson());
    return Matiere.fromJson(response.data['data'] as Map<String, dynamic>);
  }

  Future<Matiere> update(int id, Matiere matiere) async {
    final response =
        await _api.dio.put('/api/matieres/$id', data: matiere.toJson());
    return Matiere.fromJson(response.data['data'] as Map<String, dynamic>);
  }

  Future<void> delete(int id) async {
    await _api.dio.delete('/api/matieres/$id');
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
