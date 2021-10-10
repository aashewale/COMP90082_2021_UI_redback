from flask import Flask,request

import os
import time
import numpy as np
#import neuspell
import csv
import re
import sys
import language_tool_python
#import tensorflow as tf
#from neuspell import BertChecker
import transformers   #T5ForConditionalGeneration, T5Tokenizer, 
from googletrans import Translator
from pprint import pprint

app = Flask(__name__)


summary_min_length_ratio = 0.6
summary_max_length_ratio = 0.8
min_word_count_for_summarisation = 20


# https://stackoverflow.com/questions/919056/case-insensitive-replace
def simplify_words_and_phrases(text):
    for key in imported_words_and_phrases.keys():
        case_insensitive_re = re.compile(re.escape(key), re.IGNORECASE)
        text = case_insensitive_re.sub(imported_words_and_phrases[key], text)
    return text

def convert_text(text, summariser, spell_checker, start_time , verbose=False):
    text = str(text)
    toReturn = ""
    if verbose: toReturn += "Initial text:     " + text + '\n\n'

    word_count = len(text.split())
    if verbose: toReturn += "Word count:" + str(word_count) + '\n\n'

    min_words = int(np.ceil(word_count * summary_min_length_ratio))
        
    if verbose: toReturn +=" Min words:" + str(min_words) + '\n\n'

    max_words = int(np.ceil(word_count * summary_max_length_ratio))
    if verbose: toReturn += " Max words:"+ str(max_words) + '\n\n'

    text = spell_checker.correct(text)
    if verbose: toReturn += "Spellchecked text:" +  text + '\n\n'

    if word_count > min_word_count_for_summarisation:
        text = summariser(text, max_length=max_words, min_length=min_words, do_sample=False)[0]['summary_text']
        if verbose: toReturn += "Summarised text:  " + text + '\n\n'

    if word_count > 0:
        text = simplify_words_and_phrases(text)
        if verbose: toReturn += "Substituted text: " + text + '\n\n'

        proxy_translation = translator.translate(text, src="en", dest="de")
        text = proxy_translation.text
        if verbose: toReturn += "Proxy text:       " + text + '\n\n'

        simplified_translation = translator.translate(text, src="de", dest="en")
        text = simplified_translation.text
        if verbose: toReturn += "Translated back:  "+ text + '\n\n'
            
    if verbose: final_text = "Final text:       " + text + '\n\n'
        
   # if verbose: print("-------------------------------------------------------------------------------------", end='\n')
    print("--- %s seconds ---" % (time.time() - start_time))

    return text


# In[5]:


os.environ["CUDA_VISIBLE_DEVICES"] = "0"
#summariser = transformers.pipeline("summarization", model="t5-base", tokenizer="t5-base", framework="pt")
summariser = transformers.pipeline("summarization", model="facebook/bart-large-cnn", tokenizer="facebook/bart-large-cnn", framework="pt")
spell_checker = language_tool_python.LanguageTool('en-US')
translator = Translator()


# https://realpython.com/python-csv/
imported_words_and_phrases = {}
with open('simplified-words-and-phrases.csv',encoding= 'unicode_escape') as csv_file:
    csv_reader = csv.reader(csv_file, delimiter=',')
    for row in csv_reader:
        imported_words_and_phrases[row[0]] = row[1]
print("running ...")


@app.route("/", methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        text = request.form.get('text')
        start_time = time.time()
        #result = "You celebrate every achievement and success with me . I could not have asked for a better mum for me , I love more than words can say ."
        return convert_text(text, summariser, spell_checker, start_time ,verbose=True)
    return ""

if __name__ == "__main__":
    app.run()