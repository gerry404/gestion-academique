import 'package:flutter/foundation.dart';

import '../models/matiere.dart';
import '../services/matiere_service.dart';

class MatiereProvider extends ChangeNotifier {
  MatiereProvider(this._service);

  final MatiereService _service;

  List<Matiere> _matieres = [];
  bool _isLoading = false;
  String? _error;
  String _search = '';

  List<Matiere> get matieres => _matieres;
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
      _matieres = await _service.list(search: _search);
    } catch (e) {
      _error = MatiereService.messageFromError(e);
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<bool> create(Matiere matiere) async {
    try {
      final created = await _service.create(matiere);
      _matieres = [..._matieres, created]
        ..sort((a, b) => a.code.compareTo(b.code));
      notifyListeners();
      return true;
    } catch (e) {
      _error = MatiereService.messageFromError(e);
      notifyListeners();
      return false;
    }
  }

  Future<bool> update(int id, Matiere matiere) async {
    try {
      final updated = await _service.update(id, matiere);
      _matieres = [
        for (final m in _matieres) m.id == id ? updated : m,
      ];
      notifyListeners();
      return true;
    } catch (e) {
      _error = MatiereService.messageFromError(e);
      notifyListeners();
      return false;
    }
  }

  Future<bool> delete(int id) async {
    try {
      await _service.delete(id);
      _matieres = _matieres.where((m) => m.id != id).toList();
      notifyListeners();
      return true;
    } catch (e) {
      _error = MatiereService.messageFromError(e);
      notifyListeners();
      return false;
    }
  }
}
