import 'package:flutter/foundation.dart';

import '../models/etudiant.dart';
import '../services/etudiant_service.dart';

class EtudiantProvider extends ChangeNotifier {
  EtudiantProvider(this._service);

  final EtudiantService _service;

  List<Etudiant> _etudiants = [];
  bool _isLoading = false;
  String? _error;
  String _search = '';

  List<Etudiant> get etudiants => _etudiants;
  bool get isLoading => _isLoading;
  String? get error => _error;
  String get search => _search;

  Future<void> load({String? search}) async {
    if (search != null) {
      _search = search;
    }
    _isLoading = true;
    _error = null;
    notifyListeners();
    try {
      _etudiants = await _service.list(search: _search);
    } catch (e) {
      _error = EtudiantService.messageFromError(e);
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  Future<bool> create(Etudiant etudiant) async {
    try {
      final created = await _service.create(etudiant);
      _etudiants = [..._etudiants, created]
        ..sort((a, b) => a.nom.compareTo(b.nom));
      notifyListeners();
      return true;
    } catch (e) {
      _error = EtudiantService.messageFromError(e);
      notifyListeners();
      return false;
    }
  }

  Future<bool> update(int id, Etudiant etudiant) async {
    try {
      final updated = await _service.update(id, etudiant);
      _etudiants = [
        for (final e in _etudiants) e.id == id ? updated : e,
      ];
      notifyListeners();
      return true;
    } catch (e) {
      _error = EtudiantService.messageFromError(e);
      notifyListeners();
      return false;
    }
  }

  Future<bool> delete(int id) async {
    try {
      await _service.delete(id);
      _etudiants = _etudiants.where((e) => e.id != id).toList();
      notifyListeners();
      return true;
    } catch (e) {
      _error = EtudiantService.messageFromError(e);
      notifyListeners();
      return false;
    }
  }
}
