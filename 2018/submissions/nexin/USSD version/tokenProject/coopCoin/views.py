from __future__ import unicode_literals
from django.shortcuts import render
from django.http import HttpResponse
# Create your views here.
import requests
from django.views.decorators.csrf import csrf_exempt
from stellar_base.keypair import Keypair
from stellar_base.asset import Asset
import json



"""
USSD Gateway to access crypto bonds data

we didn't manage to finish
"""
@csrf_exempt
def index(request):
    if request.method == 'POST':
        session_id = request.POST.get('sessionId')
        service_code = request.POST.get('serviceCode')
        phone_number = request.POST.get('phoneNumber')
        text = request.POST.get('text')
        response = ""

        if text == "":
            response = "CON Welcome to Crpyto Bonds \n \n"
            response += "1. Create Account \n"
            response += "2. Sell Crypto Bonds \n"
            response += "3. Check Crypto balance \n"

        if text=="1":
            response = "CON Crpyto Bonds \n \n"
            response += " Enter National id \n"

        if len(text) == 18 and text.startswith("1*"):
            code,id = text.split("*")
            data = {
                "id":id,
                "phone":phone_number
            }
            r = requests.post('http://573f334e.ngrok.io/register/',data=data)
            result = r.json()
            response = "CON Crpyto Bonds \n \n"
            response += "Thanks for registering"

        return HttpResponse(response)


"""
Group work assigned to team nexin to make offers page
"""
def orderBook(request,publicKey):
    r = requests.get('https://horizon-testnet.stellar.org/accounts/'+str(publicKey)+'/offers/')
    result = r.json()
    records = result['_embedded']['records']
    return render(request, "EcoHack.html", {"records":records})
