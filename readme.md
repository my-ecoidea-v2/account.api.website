# Account.Api.My-EcoIdea.org Documentation

===

[api/register]
## Création d’un utilisateur
> request type : json
> method : post
> fields :
- ‘name’ required | max:75
- ‘key’ //clés bêta
- ‘email’ required | max:191
- ‘password’ required | min :6
- ‘password_confirmation’ required |
return :
- success | ‘token’:’[user_token]’, ‘user’ :’[user_informations]’
- error | ‘error :’[error_description]

[api/login]
## Connexion d’un utilisateur
> request type : json
> method : post
> fields :
- ‘email’ required | max:191
- ‘password’ required | min :6
return :
- success | ‘token’:’[user_token]’
- error | ‘error :’[error_description]

[api/logout]
## Déconnexion d’un utilisateur
> request type : json
> method : post
> fields :
- ‘token’ required
return :
- success | ‘status’:’success’

[api/user]
## Récupération d’informations sur un utilisateur
> request type : json
> method : get
> fields :
- ‘token’ required
return :
success | ‘user’:’[user_information]’