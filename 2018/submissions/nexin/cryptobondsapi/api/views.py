from django.shortcuts import render

from django.http import JsonResponse, HttpResponse, HttpResponseRedirect
from django.contrib.auth.decorators import login_required, permission_required
from django.views.decorators.csrf import csrf_exempt, csrf_protect
from django.contrib import auth
import requests
import json
import datetime
import time
from stellar_base.keypair import Keypair
from .models import *

# Create your views here.

fund_url = 'https://horizon-testnet.stellar.org/friendbot?addr='
SU_PK = "GB4JZDVSG74NU3IRUPIMVX2QSNAFI4OEEPKDFGOVNI5SPNIKYMF6A445"
SU_SK = "SB4HD7AJZQEMSF7M2LRZTJZUGYUBRW4W75A2CNPVTGJDWD2TYUDXN2YX"

def index(request):
    return JsonResponse({"Hello": "World"}, safe=False)


@csrf_exempt
def register(request):
    if request.method == 'POST':
        nid = request.POST.get('id', '')
        phone = request.POST.get('phone', '')

        response = {}
        response_status = 200

        check = Account.objects.filter(id=nid)

        if True:
    

            kp = Keypair.random()
            public_key = kp.address().decode()
            private_key = kp.seed().decode()


            r = requests.get(fund_url+public_key)


            if r.status_code == 200:

                Account.objects.create(
                    phone=phone,
                    id=nid,
                    public_key=public_key,
                    private_key=private_key
                )

                response['private_key'] = private_key
                response['public_key'] = public_key
                response['phone'] = phone
                response['id'] = nid

                response_status = 200

            else:
                response['message'] = "Something went wrong. Please try again"
                response_status = 402

            return JsonResponse(response, status=response_status, safe=False)

        else:
            response_status = 301
            response['message'] = "This account is already registered."

            return JsonResponse(response, status=response_status, safe=False)



#CREATING BONDS

#def makeNewBonds(request, counter):



            



