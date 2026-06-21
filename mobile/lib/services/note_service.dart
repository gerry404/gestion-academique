import 'package:dio/dio.dart';

import '../api/api_client.dart';
import '../models/note.dart';

class NoteService {
  NoteService(this._api);

  final ApiClient _api;

  Future<List<Note>> list() async {
    final response = await _api.dio.get('/api/notes');
    final data = response.data['data'] as List<dynamic>;
    return data.map((e) => Note.fromJson(e as Map<String, dynamic>)).toList();
  }

  Future<Note> create(Note note) async {
    final response = await _api.dio.post('/api/notes', data: note.toJson());
    return Note.fromJson(response.data['data'] as Map<String, dynamic>);
  }

  Future<Note> update(int id, Note note) async {
    final response =
        await _api.dio.put('/api/notes/$id', data: note.toJson());
    return Note.fromJson(response.data['data'] as Map<String, dynamic>);
  }

  Future<void> delete(int id) async {
    await _api.dio.delete('/api/notes/$id');
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
