class LoginCredentials {
  const LoginCredentials({
    required this.email,
    required this.password,
    this.remember = false,
  });

  final String email;
  final String password;
  final bool remember;

  Map<String, dynamic> toJson() => {
        'email': email,
        'password': password,
        'remember': remember,
      };
}
