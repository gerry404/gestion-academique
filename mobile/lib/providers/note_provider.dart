import 'package:flutter/foundation.dart';

import '../models/note.dart';
import '../services/note_service.dart';

class NoteProvider extends ChangeNotifier {
  NoteProvider(this._service);

  final NoteService _service;

  List<Note> _notes = [];
  bool _isLoading = false;
  String? _error;

  List<Note> get notes => _notes;
  bool get isLoading => _isLoading;
  String? get error => _error;

  Future<void> load() async {
    _isLoading = true;
    _error = null;
    notifyListeners();
    try {
      _notes = await _service.list();
    } catch (e) {
      _error = NoteService.messageFromError(e);
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<bool> create(Note note) async {
    try {
      final created = await _service.create(note);
      _notes = [created, ..._notes];
      notifyListeners();
      return true;
    } catch (e) {
      _error = NoteService.messageFromError(e);
      notifyListeners();
      return false;
    }
  }

  Future<bool> update(int id, Note note) async {
    try {
      final updated = await _service.update(id, note);
      _notes = [
        for (final n in _notes) n.id == id ? updated : n,
      ];
      notifyListeners();
      return true;
    } catch (e) {
      _error = NoteService.messageFromError(e);
      notifyListeners();
      return false;
    }
  }

  Future<bool> delete(int id) async {
    try {
      await _service.delete(id);
      _notes = _notes.where((n) => n.id != id).toList();
      notifyListeners();
      return true;
    } catch (e) {
      _error = NoteService.messageFromError(e);
      notifyListeners();
      return false;
    }
  }
}
