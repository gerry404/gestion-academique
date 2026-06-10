import 'package:dio/dio.dart';

import '../config/app_config.dart';
import '../services/token_storage.dart';

class ApiClient {
  ApiClient._(this.dio);

  final Dio dio;

  static ApiClient? _instance;

  static ApiClient get instance {
    final instance = _instance;
    if (instance == null) {
      throw StateError(
        'ApiClient non initialise. Appelez ApiClient.init() dans main().',
      );
    }
    return instance;
  }

  static Future<ApiClient> init(TokenStorage tokenStorage) async {
    final dio = Dio(
      BaseOptions(
        baseUrl: AppConfig.apiUrl,
        headers: {
          'Accept': 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
      ),
    );

    dio.interceptors.add(
      InterceptorsWrapper(
        onRequest: (options, handler) async {
          final token = await tokenStorage.read();
          if (token != null) {
            options.headers['Authorization'] = 'Bearer $token';
          }
          handler.next(options);
        },
      ),
    );

    final client = ApiClient._(dio);
    _instance = client;
    return client;
  }
}
