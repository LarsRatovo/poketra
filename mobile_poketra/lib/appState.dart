import 'package:flutter/material.dart';

class AppState extends ChangeNotifier{
  String? token;
  bool isLogged = false;

  setToken(String token){
    this.token = token;
    isLogged = true;
    notifyListeners();
  }
}