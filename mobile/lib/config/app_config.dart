import 'package:flutter/foundation.dart';

class AppConfig {
  AppConfig._();

  static const String _override = String.fromEnvironment('API_URL');

  static String get apiUrl {
    if (_override.isNotEmpty) {
      return _override;
    }
    return kIsWeb ? 'http://localhost:8000' : 'http://10.0.2.2:8000';
  }
}
