from django.conf.urls import url,include
from . import views

urlpatterns = [
    url('^orders/<slug:publicKey>$', views.orderBook, name='order'),
    url('^$', views.index, name='index'),
]
