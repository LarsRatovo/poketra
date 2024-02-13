import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:mobile_poketra/host.dart';
import 'package:mobile_poketra/appState.dart';
import 'package:provider/provider.dart';

class Login extends StatefulWidget{

  const Login({super.key});
  @override
  State<Login> createState() => _LoginState();
}

class _LoginState extends State<Login> {
  final GlobalKey<FormState> _formkey = GlobalKey<FormState>();
  final emailController = TextEditingController();
  final passwordController = TextEditingController(); 
  bool _hidePassword = true;
  switchHidePassowrd(){
    setState(() {
      _hidePassword = !_hidePassword;
    });
  }
  @override
  Widget build(BuildContext context) {
    var states = context.watch<AppState>();

    var theme = Theme.of(context).colorScheme;
    return SafeArea(
      child: Card(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children:[
            const Image(
              image: AssetImage("assets/logo-name.png"),
              width: 150,
            ),
            const SizedBox(height: 50),
            Form(
            key: _formkey,
            child: Column(
              children: [
                TextFormField(
                  decoration: InputDecoration(
                    labelText: 'E-mail',
                    border: const OutlineInputBorder(),
                    prefixIcon: const Icon(Icons.mail),
                    iconColor: theme.primary,
                  ),
                  validator: (String? value){
                    if(value == null || value.trim().isEmpty){
                      return "L'e-mail est obligatoire";
                    }
                    return null;
                  },
                  autocorrect: false,
                  controller: emailController,
                ),
                const SizedBox(height: 20),
                TextFormField(
                  obscureText: _hidePassword,
                  decoration: InputDecoration(
                    labelText: 'Mot de passe',
                    border: const OutlineInputBorder(),
                    prefixIcon: const Icon(Icons.password),
                    iconColor: theme.primary,
                    suffixIcon: Padding(
                      padding: const EdgeInsets.fromLTRB(0,0,0,0),
                      child: GestureDetector(
                        onTap: switchHidePassowrd,
                        child: Icon( _hidePassword ? Icons.visibility_outlined : Icons.visibility_off)
                        )
                      )
                  ),
                  validator: (String? value){
                    if(value == null || value.trim().isEmpty){
                      return "Le mot de passe est obligatoire";
                    }
                    return null;
                  },
                  controller: passwordController,
                ),
                const SizedBox(height: 10),
                GestureDetector(
                  onTap: ()=>
                  {
                    print("Forgot")
                  },
                  child: const Text("Mot de passe oublié ?")),
                const SizedBox(height: 10),
                FilledButton(
                  onPressed:()=>{
                    if(_formkey.currentState!.validate()){
                      http.post(Uri.parse("$host/api/login_check"),body: jsonEncode(<String,String>{
                        'username':emailController.text.trim(),
                        'password':passwordController.text.trim()
                      })).then((value) =>{
                        states.setToken("lolo")
                      }).catchError((error){
                        print(error);
                        return null;
                      })
                    }
                  },
                  child: const Text("Se connecter")
                )
              ],
            )
          ),
          ]
        ),
      ),
    ) ;
  }
}