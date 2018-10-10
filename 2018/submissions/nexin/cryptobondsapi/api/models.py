from django.db import models
import time

TIME_NOW = str(int(round(time.time() * 1000)))

# Create your models here.
"""
class Bond(models.Model):
    name = models.CharField(max_length=100)
    time = models.CharField(max_length=50, default=TIME_NOW)

"""

class Account(models.Model):
    phone = models.CharField(max_length=20)
    private_key = models.CharField(max_length=100)
    public_key = models.CharField(max_length=100)
    id = models.CharField(max_length=20, primary_key=True, unique=True, editable=True)

    def __str__(self):
        return self.id
