# K-Nearest Neighbors (K-NN)

# Importing the libraries
import pandas as pd

# Importing the dataset
dataset = pd.read_csv('DataSetFinal2.csv')
X = dataset.iloc[:, [0,1,2,3,4]].values
y = dataset.iloc[:, 5].values

# Splitting the dataset into the Training set and Test set
from sklearn.cross_validation import train_test_split
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size = 0.25, random_state = 0)

# Feature Scaling
from sklearn.preprocessing import StandardScaler
sc = StandardScaler()
X_train = sc.fit_transform(X_train)
X_test = sc.transform(X_test)

# Fitting K-NN to the Training set
from sklearn.neighbors import KNeighborsClassifier
Acounter = 0
Apercent = 0
Aperfect = 0
for x in range(1, 500):
    classifier = KNeighborsClassifier(n_neighbors = x, weights='distance' ,algorithm='auto',metric = 'minkowski', p = 2) 
    classifier.fit(X_train, y_train)

# Predicting the Test set results
    y_pred = classifier.predict(X_test)
    for a in range(0, len(y_pred)):
        if y_pred[a] == y_test[a]:
            Acounter += 1
    if round((Acounter/len(y_pred) * 100), 1) > Apercent:
        Apercent = round((Acounter/len(y_pred) * 100), 1)
        Aperfect = x
        Acounter = 0
    else:
        Acounter = 0
