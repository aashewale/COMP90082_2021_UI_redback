#!/usr/bin/env python
# coding: utf-8

# In[1]:


# https://towardsdatascience.com/abstractive-summarization-using-pytorch-f5063e67510

# Vocabulary documents use:
# https://www.plainlanguage.gov/guidelines/words/use-simple-words-phrases/
# http://www.plainenglish.co.uk/the-a-z-of-alternative-words.html


# ## Import Library

# In[2]:


import os
import numpy as np
import neuspell
import csv
import re
import sys
import language_tool_python
import tensorflow as tf
from neuspell import BertChecker
from transformers import pipeline, BartForConditionalGeneration, BartTokenizer #T5ForConditionalGeneration, T5Tokenizer, 
from googletrans import Translator, constants
from pprint import pprint


# In[3]:


# Global constants
summary_min_length_ratio = 0.6
summary_max_length_ratio = 0.8
min_word_count_for_summarisation = 20
result = ""
for i in range(1, len(sys.argv)):
    result = result + sys.argv[i] + " "

# In[4]:


# https://stackoverflow.com/questions/919056/case-insensitive-replace
def simplify_words_and_phrases(text):
    for key in imported_words_and_phrases.keys():
        case_insensitive_re = re.compile(re.escape(key), re.IGNORECASE)
        text = case_insensitive_re.sub(imported_words_and_phrases[key], text)
    return text

def convert_text(text, summariser, spell_checker, verbose=False):
    text = str(text)
    if verbose: print("Initial text:     ", text, end='\n\n')

    word_count = len(text.split())
    if verbose: print("Word count:", word_count, end='\n\n')

    min_words = int(np.ceil(word_count * summary_min_length_ratio))
    if verbose: print(" Min words:", min_words, end='\n\n')

    max_words = int(np.ceil(word_count * summary_max_length_ratio))
    if verbose: print(" Max words:", max_words, end='\n\n')

    text = spell_checker.correct(text)
    if verbose: print("Spellchecked text:", text, end='\n\n')

    if word_count > min_word_count_for_summarisation:
        text = summariser(text, max_length=max_words, min_length=min_words, do_sample=False)[0]['summary_text']
        if verbose: print("Summarised text:  ", text, end='\n\n')

    if word_count > 0:
        text = simplify_words_and_phrases(text)
        if verbose: print("Substituted text: ", text, end='\n\n')

        proxy_translation = translator.translate(text, src="en", dest="de")
        text = proxy_translation.text
        if verbose: print("Proxy text:       ", text, end='\n\n')

        simplified_translation = translator.translate(text, src="de", dest="en")
        text = simplified_translation.text
        if verbose: print("Translated back:  ", text, end='\n\n')
        
    if verbose: print("Final text:       ", text, end='\n\n')
        
    if verbose: print("-------------------------------------------------------------------------------------", end='\n')
        
    return text


# In[5]:


os.environ["CUDA_VISIBLE_DEVICES"] = "0"
# summariser = pipeline("summarization", model="t5-base", tokenizer="t5-base", framework="pt")
summariser = pipeline("summarization", model="facebook/bart-large-cnn", tokenizer="facebook/bart-large-cnn", framework="pt")
spell_checker = language_tool_python.LanguageTool('en-US')
translator = Translator()

# https://realpython.com/python-csv/
imported_words_and_phrases = {}
with open('simplified-words-and-phrases.csv',encoding= 'unicode_escape') as csv_file:
    csv_reader = csv.reader(csv_file, delimiter=',')
    for row in csv_reader:
        imported_words_and_phrases[row[0]] = row[1]


# In[6]:


#convert_text("He couldn't remember his account password. He could only recall some special characters such as #$%^ which he was using in all of his passwords. He also knew that his password was 10 characters long from which three were % character and three were ^&* characters", summariser, spell_checker, verbose=True)

convert_text(result, summariser, spell_checker, verbose=True)


# In[7]:


# with open('test-cases.txt', 'r') as posts:
#     for post in posts:
#         convert_text(post, summariser, spell_checker, verbose=True)


# In[8]:


# # THIS BLOCK FINE-TUNES THE MODEL - WILL JUST NEED TO LOOP THROUGH INSTANCE/LABEL PAIRS ON PASSING FROM SITE.
# # https://huggingface.co/transformers/model_doc/t5.html

# instance = "Today is a very very special day!! You know why??? Because it is the Birthday of this amazing lady!!! Mum Theodosia Green you give me strength I never knew I had, you support me through every dumb idea(there's been a few), every challenge, every sadness. You celebrate every achievement and success with me. I could not have asked for a better mum for me, I love you more than words can say. I am so proud of you, your journey has had a lot of highs and lows but you are 1 of the strongest women I know and can do anything you set your mind too!! You are so loving and generous. I hope today brings you as much joy as watching fail videos bring you (she loves them). I am so proud and honoured to call you my mum. Happy Birthday."
# label = "Theodosia Green is one of the strongest women I know. She can do what she wants. Today is a very special day! You know why? Because it is this amazing lady's birthday. With me you celebrate every success."

# input_updates = summariser.tokenizer(instance, return_tensors='pt').input_ids
# labels_updates = summariser.tokenizer(label, return_tensors='pt').input_ids

# summariser.model(input_ids=input_updates, labels=labels_updates)


# In[ ]:
